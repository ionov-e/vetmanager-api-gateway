<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;

abstract class AbstractDTO
{
    /** @throws VetmanagerApiGatewayResponseEmptyException */
    protected function __construct(
        protected ApiGateway     $apiGateway,
        readonly protected array $originalData
    ) {
        if (empty($this->originalData)) {
            throw new VetmanagerApiGatewayResponseEmptyException();
        }
    }

    /** @throws VetmanagerApiGatewayResponseEmptyException */
    public static function fromDecodedJson(ApiGateway $apiGateway, array $array): static
    {
        return new static ($apiGateway, $array);
    }

    /** @throws VetmanagerApiGatewayResponseEmptyException */
    public static function fromJson(ApiGateway $apiGateway, string $json): static
    {
        return static::fromDecodedJson($apiGateway, json_decode($json));
    }

    /** Возвращение данных в том же виде, в котором и были получены (массив из раздекодированного JSON) */
    public function getOriginalArray(): array
    {
        return $this->originalData;
    }
}
