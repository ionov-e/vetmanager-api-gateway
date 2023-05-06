<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\Enum\ApiRoute;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;

abstract class AbstractActiveRecord
{
    /**
     * @param ApiGateway $apiGateway
     * @param array<string, mixed> $originalData Данные в том виде, в котором были получены (массив из раздекодированного JSON)
     */
    protected function __construct(
        readonly protected ApiGateway $apiGateway,
        readonly public array         $originalData
    ) {
    }

    abstract public static function getApiModel(): ApiRoute;

    /** @param array<string, mixed> $objectContents Содержимое: {id: 13, ...}
     * @throws VetmanagerApiGatewayResponseEmptyException
     * @psalm-suppress UnsafeInstantiation
     */
    public static function fromSingleObjectContents(ApiGateway $apiGateway, array $objectContents): static
    {
        if (empty($objectContents)) {
            throw new VetmanagerApiGatewayResponseEmptyException();
        }

        return new static ($apiGateway, $objectContents);
    }

    /**
     * @param array $objects Массив объектов. Каждый элемент которого - массив с содержимым объекта: {id: 13, ...}
     *
     * @return static[]
     *
     * @throws VetmanagerApiGatewayResponseEmptyException
     */
    public static function fromMultipleObjectsContents(ApiGateway $apiGateway, array $objects): array
    {
        return array_map(
            fn (array $objectContents): static => static::fromSingleObjectContents($apiGateway, $objectContents),
            $objects
        );
    }
}
