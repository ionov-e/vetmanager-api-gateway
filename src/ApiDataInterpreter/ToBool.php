<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ApiDataInterpreter;

use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

class ToBool
{
    public function __construct(private readonly ?bool $boolOrNull)
    {
    }

    /**
     * @param ?string $boolAsStringOrNull Строка содержащая null или bool (Например: '13.13')
     *
     * @throws VetmanagerApiGatewayResponseException
     */
    public static function fromStringOrNull(?string $boolAsStringOrNull): self
    {
        if (is_null($boolAsStringOrNull)) {
            return new self(null);
        }

        $filteredBool = filter_var($boolAsStringOrNull, FILTER_VALIDATE_BOOL);

        if (is_bool($filteredBool)) {
            return new self($filteredBool);
        }

        throw new VetmanagerApiGatewayResponseException("Ожидали null или bool (даже если 'on', 'yes', ..), а получили: $boolAsStringOrNull");
    }

    public function getBoolOrNull(): ?bool
    {
        return $this->boolOrNull;
    }

    /** Для тех случаев, когда уверены, что null и пустых значений не будет
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getBoolOrThrowIfNull(): bool
    {
        if (is_null($this->boolOrNull)) {
            throw new VetmanagerApiGatewayResponseException("Не ожидали получить null");
        }

        return $this->boolOrNull;
    }
}