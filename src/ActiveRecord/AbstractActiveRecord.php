<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO\AbstractModelDTO;

abstract class AbstractActiveRecord
{
    protected ApiGateway $apiGateway;
    protected AbstractModelDTO $modelDTO;

    /** Используется при АПИ-запросах (роуты и имена моделей из тела JSON-ответа на АПИ запрос) */
    abstract public static function getApiModel(): ApiModel;

    protected static function setNewModelDtoFluently(self $object, AbstractModelDTO $newModelDto): static
    {
        $clone = clone $object;
        $clone->modelDTO = $newModelDto;
        return $clone;
    }
}
