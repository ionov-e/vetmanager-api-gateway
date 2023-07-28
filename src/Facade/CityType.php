<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade\Interface\AllRequestsInterface;

class CityType extends AbstractFacade implements AllRequestsInterface
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