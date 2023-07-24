<?php

namespace VetmanagerApiGateway\Facade;

use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\DTO\CityDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class City extends AbstractFacade
{
    private static function getApiModel()
    {
        return ActiveRecord\City::getApiModel();
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ActiveRecord\City
    {
        return self::protectedGetById(
            $this->apiGateway,
            self::getApiModel(),
            ActiveRecord\City::class,
            CityDto::class,
            $id
        );
    }
}