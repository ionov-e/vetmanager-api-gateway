<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\Hydrator;

use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

/**
 * @property-read int $int Для тех случаев, когда уверены, что null и пустых значений не будет
 * @property-read ?int $noneZeroIntOrNull Преобразует 0 в null
 * @property-read positive-int $positiveInt Для тех случаев, когда уверены, что null и пустых значений не будет
 * @property-read ?positive-int $positiveIntOrNull Преобразует 0 в null
 */
class ApiInt
{
    public function __construct(private readonly ?int $intOrNull)
    {
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

    /** @throws VetmanagerApiGatewayResponseException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'int' => $this->getInt(),
            'noneZeroIntOrNull' => $this->getNonZeroIntOrNull(),
            'positiveInt' => $this->getPositiveInt(),
            'positiveIntOrNull' => $this->getPositiveIntOrNull(),
            default => $this->$name,
        };
    }

    private function getNonZeroIntOrNull(): ?int
    {
        return ($this->intOrNull === 0) ? null : $this->intOrNull;
    }

    /** @throws VetmanagerApiGatewayResponseException */
    private function getInt(): int
    {
        if (is_null($this->intOrNull)) {
            throw new VetmanagerApiGatewayResponseException("Не ожидали получить null");
        }

        return $this->intOrNull;
    }

    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    private function getPositiveInt(): int
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
    private function getPositiveIntOrNull(): ?int
    {
        if (!is_null($this->intOrNull) && $this->intOrNull < 0) {
            throw new VetmanagerApiGatewayResponseException("Не ожидали не positive-int");
        }

        return ($this->intOrNull === 0) ? null : $this->intOrNull;
    }
}
