<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;

abstract class AbstractDTO
{
    protected function __construct(public array $originalDataArray)
    {
    }

    /** @psalm-suppress UnsafeInstantiation */
    public static function createEmpty(): static
    {
        return new static([]);
    }

    abstract public static function fromApiResponseArray(array $originalDataArray): self;

    /** Список обязательных ключей
     * @return string[]
     */
    abstract public function getRequiredKeysForPostArray(): array;

    /** Получение записанного пользователем DTO в виде массива (без поля с ID) для Post или Put запроса
     * @return array<string, null|int|float|string|array>
     */
    abstract protected function getSetValuesWithoutId(): array;

    /** @throws VetmanagerApiGatewayRequestException */
    public function getAsArrayForPostRequest(): array
    {
        $this->throwIfRequiredFieldForPostIsMissing();
        return $this->getAsArrayForPostOrPutRequest();
    }

    /** @throws VetmanagerApiGatewayRequestException */
    public function getAsArrayForPutRequest(): array
    {
        return $this->getAsArrayForPostOrPutRequest();
    }

    /** @throws VetmanagerApiGatewayRequestException */
    public function getIdForPutRequest(): int
    {
        if (!isset($this->id)) {
            throw new VetmanagerApiGatewayRequestException('Не предоставлен ID для Put запроса');
        }

        return $this->id;
    }

    /** @throws VetmanagerApiGatewayRequestException */
    private function throwIfRequiredFieldForPostIsMissing(): void
    {
        $arrayForPostRequest = $this->getAsArrayForPostOrPutRequest();

        foreach ($this->getRequiredKeysForPostArray() as $requiredKey) {
            if (!array_key_exists($requiredKey, $arrayForPostRequest)) {
                throw new VetmanagerApiGatewayRequestException(
                    "Пытались отправить Post-запрос объекта " . self::class . " без обязательного поля: $requiredKey"
                );
            }
        }
    }

    /** @throws VetmanagerApiGatewayRequestException */
    private function getAsArrayForPostOrPutRequest(): array
    {
        $arrayToSend = $this->getSetValuesWithoutId();

        if (empty($arrayToSend)) {
            throw new VetmanagerApiGatewayRequestException('Пытаемся отправить пустую модель');
        }

        return $arrayToSend;
    }
}
