<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ApiDataInterpreter;

use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

class ToFloat
{
    public function __construct(private readonly ?float $floatOrNull)
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

    /** Преобразует 0 в null */
    public function getNonZeroFloatOrNull(): ?float
    {
        return ($this->floatOrNull === 0.0) ? null : $this->floatOrNull;
    }

    /** Для тех случаев, когда уверены, что null и пустых значений не будет
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getFloatOrThrowIfNull(): float
    {
        if (is_null($this->floatOrNull)) {
            throw new VetmanagerApiGatewayResponseException("Не ожидали получить null");
        }

        return $this->floatOrNull;
    }
}
