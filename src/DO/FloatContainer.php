<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO;

use Exception;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

/** @property-read float $float Для тех случаев, когда уверены, что null не будет */
class FloatContainer
{
    public function __construct(public readonly ?float $floatOrNull)
    {
    }

    /**
     * @param ?string $intAsStringOrNull null, '0' - переводит в null. Строку '13' переведет int
     *
     * @throws VetmanagerApiGatewayResponseException
     */
    public static function fromStringOrNull(?string $intAsStringOrNull): self
    {
        if (!$intAsStringOrNull || "0" == $intAsStringOrNull) {
            return new self(null);
        }

        try {
            if (!is_numeric($intAsStringOrNull)) {
                return new self((int)$intAsStringOrNull);
            }
        } catch (Exception) {
        }
        throw new VetmanagerApiGatewayResponseException(
            "Ожидали int больше 0 или null. А получили: '$intAsStringOrNull'"
        );
    }

    /** @throws VetmanagerApiGatewayResponseException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'positiveInt' => $this->getPositiveInt(),
            default => $this->$name,
        };
    }

    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    private function getPositiveInt(): int
    {
        if (is_null($this->positiveIntOrNull)) {
            throw new VetmanagerApiGatewayResponseException("Не ожидали получить null");
        }

        return $this->positiveIntOrNull;
    }
}
