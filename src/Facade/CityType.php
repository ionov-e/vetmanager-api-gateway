<?php

namespace VetmanagerApiGateway\Facade;

use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\DTO\CityTypeDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class CityType extends AbstractFacade
{
    private static function getApiModel()
    {
        return ActiveRecord\CityType::getApiModel();
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ActiveRecord\CityType
    {
        return self::protectedGetById(
            $this->apiGateway,
            self::getApiModel(),
            ActiveRecord\CityType::class,
            CityTypeDto::class,
            $id
        );
    }
}