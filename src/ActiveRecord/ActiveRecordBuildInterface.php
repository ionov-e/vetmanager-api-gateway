<?php

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO\AbstractModelDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

interface ActiveRecordBuildInterface
{
    /** @throws VetmanagerApiGatewayException */
    public static function fromResponseAsArray(ApiGateway $apiGateway, array $apiResponseAsArray): AbstractActiveRecord;

    /** @throws VetmanagerApiGatewayException */
    public static function fromSingleModelAsArray(ApiGateway $apiGateway, array $modelAsArray): AbstractActiveRecord;

    public static function fromSingleDto(ApiGateway $apiGateway, AbstractModelDTO $modelDto): AbstractActiveRecord;
}