<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO;

use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

/**
 * @property-read string string Даже если null приходит - пустую строку возвращает
 * @property-read string stringOrThrowIfNull Для тех случаев, когда уверены, что null не будет
 * @property-read non-empty-string nonEmptyString Для тех случаев, когда уверены, что не пустая строка должна прийти
 */
class StringContainer
{
    public function __construct(public readonly ?string $stringOrNull)
    {
    }

    public static function fromStringOrNull(?string $stringOrNull): self
    {
        return new self($stringOrNull);
    }

    /** @throws VetmanagerApiGatewayResponseException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'string' => $this->getStringEvenIfNullGiven(),
            'stringOrThrowIfNull' => $this->getStringOrThrowIfNull(),
            'nonEmptyString' => $this->getNonEmptyStringOrThrow(),
            default => $this->$name,
        };
    }

    private function getStringEvenIfNullGiven(): string
    {
        return $this->stringOrNull ?? '';
    }

    /** @throws VetmanagerApiGatewayResponseException */
    private function getStringOrThrowIfNull(): string
    {
        if (is_null($this->stringOrNull)) {
            throw new VetmanagerApiGatewayResponseException("Не ожидали получить null");
        }

        return $this->stringOrNull;
    }

    /** @return non-empty-string
     * @throws VetmanagerApiGatewayResponseException
     */
    private function getNonEmptyStringOrThrow(): string
    {
        if (empty($this->stringOrNull)) {
            throw new VetmanagerApiGatewayResponseException("Не ожидали получить пустую строку");
        }

        return $this->stringOrNull;
    }
}
