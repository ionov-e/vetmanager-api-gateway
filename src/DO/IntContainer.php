<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO;

use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

/**
 * @property-read int $int Для тех случаев, когда уверены, что null и пустых значений не будет
 * @property-read ?int $intOrNull Преобразует 0 в null
 * @property-read positive-int $positiveInt Для тех случаев, когда уверены, что null и пустых значений не будет
 * @property-read ?positive-int $positiveIntOrNull Преобразует 0 в null
 */
class IntContainer
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
        if (is_null($intAsStringOrNull())) {
            return new self(null);
        }

        if (is_numeric($intAsStringOrNull)) {
            return new self((int)$intAsStringOrNull);
        }

        throw new VetmanagerApiGatewayResponseException("Ожидали int или null. Получено: $intAsStringOrNull");
    }

    /** @throws VetmanagerApiGatewayResponseException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'int' => $this->getInt(),
            'intOrNull' => $this->getIntOrNull(),
            'positiveInt' => $this->getPositiveInt(),
            'positiveIntOrNull' => $this->getPositiveIntOrNull(),
            default => $this->$name,
        };
    }

    private function getIntOrNull(): ?int
    {
        return ($this->intOrNull === 0) ? null : $this->intOrNull;
    }

    /** @throws VetmanagerApiGatewayResponseException */
    private function getInt(): int
    {
        $this->throwIfNullProvided();
        return $this->intOrNull;
    }

    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    private function getPositiveInt(): int
    {
        $this->throwIfNullProvided();
        $this->throwIfNotPositiveNumber();
        return $this->getInt();
    }

    /** @return ?positive-int Вместо 0 - вернет null
     * @throws VetmanagerApiGatewayResponseException
     */
    private function getPositiveIntOrNull(): ?int
    {
        $this->throwIfNotPositiveNumberOrNull();
        return ($this->intOrNull === 0) ? null : $this->intOrNull;
    }

    /** @throws VetmanagerApiGatewayResponseException */
    private function throwIfNullProvided(): void
    {
        if (is_null($this->intOrNull)) {
            throw new VetmanagerApiGatewayResponseException("Не ожидали получить null");
        }
    }

    /** @throws VetmanagerApiGatewayResponseException */
    private function throwIfNotPositiveNumberOrNull(): void
    {
        if (!is_null($this->intOrNull)) {
            $this->throwIfNotPositiveNumber();
        }
    }

    /** @throws VetmanagerApiGatewayResponseException */
    private function throwIfNotPositiveNumber(): void
    {
        if ($this->intOrNull <= 0) {
            throw new VetmanagerApiGatewayResponseException("Не ожидали получить null");
        }
    }
}
