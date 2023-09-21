<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ApiDataInterpreter;

use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

class ToInt
{
    public function __construct(private readonly ?int $intOrNull)
    {
    }

    /**  @throws VetmanagerApiGatewayResponseException */
    public static function fromIntOrStringOrNull(null|int|string $intAsStringOrNull): self
    {
        if (is_int($intAsStringOrNull)) {
            return new self($intAsStringOrNull);
        }

        return self::fromStringOrNull($intAsStringOrNull);
    }

    /**
     * @param ?string $intAsStringOrNull Строка содержащая null или int (Например: '13')
     *
     * @throws VetmanagerApiGatewayResponseException
     */
    public static function fromStringOrNull(?string $intAsStringOrNull): self
    {
        if (is_null($intAsStringOrNull)) {
            return new self(null);
        }

        $filteredIntOrFalse = filter_var($intAsStringOrNull, FILTER_VALIDATE_INT);

        if ($filteredIntOrFalse !== false) {
            return new self($filteredIntOrFalse);
        }

        throw new VetmanagerApiGatewayResponseException("Ожидали int или null. Получено: $intAsStringOrNull");
    }

    /** Преобразует 0 в null */
    public function getNonZeroIntOrNull(): ?int
    {
        return ($this->intOrNull === 0) ? null : $this->intOrNull;
    }

    /** Преобразует null в 0 */
    public function getIntEvenIfNullGiven(): int
    {
        return $this->intOrNull ?? 0;
    }

    /** Для тех случаев, когда уверены, что null и пустых значений не будет
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getIntOrThrow(): int
    {
        if (is_null($this->intOrNull)) {
            throw new VetmanagerApiGatewayResponseException("Не ожидали получить null");
        }

        return $this->intOrNull;
    }

    /** Для тех случаев, когда уверены, что null и пустых значений не будет
     * @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getPositiveIntOrThrow(): int
    {
        if (is_null($this->intOrNull)) {
            throw new VetmanagerApiGatewayResponseException("Не ожидали получить null");
        }

        if ($this->intOrNull <= 0) {
            throw new VetmanagerApiGatewayResponseException("Не ожидали не positive-int");
        }

        return $this->intOrNull;
    }

    /** @return ?positive-int Вместо 0 - вернет null
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getPositiveIntOrNullOrThrowIfNegative(): ?int
    {
        if (!is_null($this->intOrNull) && $this->intOrNull < 0) {
            throw new VetmanagerApiGatewayResponseException("Не ожидали не positive-int");
        }

        return ($this->intOrNull === 0) ? null : $this->intOrNull;
    }
}
