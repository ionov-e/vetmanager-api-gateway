<?php

namespace VetmanagerApiGateway\Facade;

use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class City extends AbstractFacade
{
    static public function getDefaultActiveRecord(): string
    {
        return ActiveRecord\City::class;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ActiveRecord\City
    {
        return $this->protectedGetById($id, self::getDefaultActiveRecord());
    }
}