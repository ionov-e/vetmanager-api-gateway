<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class CityType extends AbstractFacade
{
    static public function getBasicActiveRecord(): string
    {
        return ActiveRecord\CityType\CityType::class;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ActiveRecord\CityType\CityType
    {
        return $this->protectedGetById(ActiveRecord\CityType\CityType::class, $id);
    }
}