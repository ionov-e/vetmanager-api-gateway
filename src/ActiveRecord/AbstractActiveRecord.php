<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO\AbstractModelDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

abstract class AbstractActiveRecord implements ActiveRecordBuildInterface
{
    public function __construct(
        protected ApiGateway       $apiGateway,
        protected AbstractModelDTO $modelDTO
    )
    {
    }

    /** @throws VetmanagerApiGatewayException */
    public static function fromResponseAsArray(ApiGateway $apiGateway, array $apiResponseAsArray): static
    {
        return $apiGateway->getActiveRecordFactory()->getActiveRecordFromApiResponseAsArray(
            $apiResponseAsArray,
            static::getModelKeyInResponse(),
            static::class,
            static::getDtoClass()
        );
    }

    /** @throws VetmanagerApiGatewayException */
    public static function fromModelAsArray(ApiGateway $apiGateway, array $modelAsArray): static
    {
        return $apiGateway->getActiveRecordFactory()->getActiveRecordFromModelAsArray(
            $modelAsArray,
            static::class,
            static::getDtoClass()
        );
    }

    public static function fromSingleDto(ApiGateway $apiGateway, AbstractModelDTO $modelDto): static
    {
        return $apiGateway->getActiveRecordFactory()->getActiveRecordFromDto($modelDto, static::class);
    }

    /** @return class-string<AbstractModelDTO> */
    abstract public static function getDtoClass(): string;

    /** Model key in ApiRequest path. Example: "{{Domain URL}}/rest/api/client" - "client" is a route key  */
    abstract public static function getRouteKey(): string;

    /** Model key in Api Response
     *
     * Example:
     * {
     * "success": true,
     * "message": "Record Retrieved Successfully",
     * "data": {
     *         "totalCount": 0,
     *         "cityType": []
     *         }
     * }
     *
     * "cityType" is the model key in response
     */
    public static function getModelKeyInResponse(): string
    {
        return static::getRouteKey();
    }

    protected static function setNewModelDtoFluently(self $object, AbstractModelDTO $newModelDto): static
    {
        $clone = clone $object;
        $clone->modelDTO = $newModelDto;
        return $clone;
    }
}
