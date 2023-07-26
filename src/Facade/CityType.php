<?php

namespace VetmanagerApiGateway\Facade;

use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class CityType extends AbstractFacade
{
    static public function getDefaultActiveRecord(): string
    {
        return ActiveRecord\CityType::class;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ActiveRecord\CityType
    {
        return $this->protectedGetById($id, ActiveRecord\CityType::class);
    }
}