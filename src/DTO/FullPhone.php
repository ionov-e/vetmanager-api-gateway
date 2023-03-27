<?php
/** @noinspection PhpUnnecessaryCurlyVarSyntaxInspection */
declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

/** Если в конструктор все 3 параметра переданы - возвращает по дефолту строку такого вида: '+7(918)123-45-67'.
 * Только без кода страны вернет: '(918)123-45-67'. Только без маски вернет: '+79181234567'. Без номера всегда: ''
 */
class FullPhone
{
    /**
     * @param string $countryCode Например: '+7'
     * @param string $number Номер без кода страны вида: '1234567890'
     * @param string $mask Сюда прилетают значения вида: '(___)-__-__-__', '(__)___-____', '____-____'
     */
    public function __construct(
        public string $countryCode,
        public string $number,
        public string $mask
    )
    {
    }

    public function getAsMaskedWithCountryCode(): string
    {
        if (empty($this->number) || str_contains($this->number, '+')) {
            return $this->number;
        }

        $numberDigitsOnly = $this->getStringWithoutSymbols($this->number);

        $countDigitsInNumber = strlen($numberDigitsOnly);
        $countDigitsInMask = substr_count($this->mask, '_');

        if (empty($this->mask) || $countDigitsInNumber !== $countDigitsInMask) { // Случай, когда маской воспользоваться нельзя
            return (empty($this->countryCode)) ? $this->number : '+' . $this->countryCode . $this->number;
        }

        return $this->getCountryCodeWithPlusIfNotEmpty() . $this->getMaskedPhoneWithoutCountryCode($numberDigitsOnly);
    }

    private function getCountryCodeWithPlusIfNotEmpty(): string
    {
        return (!empty($this->countryCode)) ? "+{$this->countryCode}" : '';
    }

    private function getMaskedPhoneWithoutCountryCode(string $numberDigitsOnly): string
    {
        $digitsEntered = 0;
        $maskedPhoneWithoutCountryCode = str_split($this->mask);

        foreach ($maskedPhoneWithoutCountryCode as &$char) { // Заменяем все символы '_' в маске на цифры из номера
            if ($char === '_') {
                $char = $numberDigitsOnly[$digitsEntered];
                $digitsEntered++;
            }
        }

        return implode('', $maskedPhoneWithoutCountryCode);
    }

    private function getStringWithoutSymbols(string $string): string
    {
        preg_match_all('!\d+!', $string, $matches);
        return implode('', $matches[0]);
    }

    public function __toString(): string
    {
        return $this->getAsMaskedWithCountryCode();
    }
}
