<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO;

use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

/**
 * @property-read bool $bool Для тех случаев, когда уверены, что null и пустых значений не будет
 */
class BoolContainer
{
    public function __construct(public readonly ?bool $boolOrNull)
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

        if (!is_null($filteredBool)) {
            return new self($filteredBool);
        }

        throw new VetmanagerApiGatewayResponseException("Ожидали null или bool (даже если 'on', 'yes', ..), а получили: $boolAsStringOrNull");
    }

    /** @throws VetmanagerApiGatewayResponseException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'bool' => $this->getBool(),
            default => $this->$name,
        };
    }

    /** @throws VetmanagerApiGatewayResponseException */
    private function getBool(): bool
    {
        if (is_null($this->boolOrNull)) {
            throw new VetmanagerApiGatewayResponseException("Не ожидали получить null");
        }

        return $this->boolOrNull;
    }
}
