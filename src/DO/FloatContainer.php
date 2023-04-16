<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO;

use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

/**
 * @property-read float $float Для тех случаев, когда уверены, что null и пустых значений не будет
 * @property-read ?float $nonZeroFloatOrNull Преобразует 0 в null
 */
class FloatContainer
{
    public function __construct(public readonly ?float $floatOrNull)
    {
    }

    /**
     * @param ?string $floatAsStringOrNull Строка содержащая null или float (Например: '13.13')
     *
     * @throws VetmanagerApiGatewayResponseException
     */
    public static function fromStringOrNull(?string $floatAsStringOrNull): self
    {
        if (is_null($floatAsStringOrNull)) {
            return new self(null);
        }

        if (is_numeric($floatAsStringOrNull)) {
            return new self((float)$floatAsStringOrNull);
        }

        throw new VetmanagerApiGatewayResponseException("Ожидали float или null. Получено: $floatAsStringOrNull");
    }

    /** @throws VetmanagerApiGatewayResponseException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'float' => $this->getFloat(),
            'nonZeroFloatOrNull' => $this->getNonZeroFloatOrNull(),
            default => $this->$name,
        };
    }

    private function getNonZeroFloatOrNull(): ?float
    {
        return ($this->floatOrNull === 0.0) ? null : $this->floatOrNull;
    }

    /** @throws VetmanagerApiGatewayResponseException */
    private function getFloat(): float
    {
        if (is_null($this->floatOrNull)) {
            throw new VetmanagerApiGatewayResponseException("Не ожидали получить null");
        }

        return $this->floatOrNull;
    }
}
