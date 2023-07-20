<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\Hydrator;

use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

class ApiString
{
    public function __construct(private readonly ?string $stringOrNull)
    {
    }

    public static function fromStringOrNull(?string $stringOrNull): self
    {
        return new self($stringOrNull);
    }

    /** Даже если null приходит - пустую строку возвращает */
    public function getStringEvenIfNullGiven(): string
    {
        return $this->stringOrNull ?? '';
    }

    /** Для тех случаев, когда уверены, что null не будет
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getStringOrThrowIfNull(): string
    {
        if (is_null($this->stringOrNull)) {
            throw new VetmanagerApiGatewayResponseException("Не ожидали получить null");
        }

        return $this->stringOrNull;
    }

    /** Для тех случаев, когда уверены, что не пустая строка должна прийти
     * @return non-empty-string
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getNonEmptyStringOrThrow(): string
    {
        if (empty($this->stringOrNull)) {
            throw new VetmanagerApiGatewayResponseException("Не ожидали получить пустую строку");
        }

        return $this->stringOrNull;
    }
}
