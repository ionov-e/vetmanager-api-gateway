<?php

namespace VetmanagerApiGateway\Facade;

use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecord\ActiveRecordBuildInterface;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO\AbstractModelDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

abstract class AbstractFacade implements ActiveRecordBuildInterface
{
    public function __construct(protected ApiGateway $apiGateway)
    {
    }

    /** @return class-string<AbstractActiveRecord> */
    abstract public static function getDefaultActiveRecord(): string;

    /** @throws VetmanagerApiGatewayException */
    public static function fromResponseAsArray(ApiGateway $apiGateway, array $apiResponseAsArray): AbstractActiveRecord
    {
        return static::getDefaultActiveRecord()::fromResponseAsArray($apiGateway, $apiResponseAsArray);
    }

    /** @throws VetmanagerApiGatewayException */
    public static function fromModelAsArray(ApiGateway $apiGateway, array $modelAsArray): AbstractActiveRecord
    {
        return static::getDefaultActiveRecord()::fromModelAsArray($apiGateway, $modelAsArray);
    }

    public static function fromSingleDto(ApiGateway $apiGateway, AbstractModelDTO $modelDto): AbstractActiveRecord
    {
        return static::getDefaultActiveRecord()::fromSingleDto($apiGateway, $modelDto);
    }
}