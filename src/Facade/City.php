<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade\Interface\AllRequestsInterface;

class City extends AbstractFacade implements AllRequestsInterface
{
    static public function getBasicActiveRecord(): string
    {
        return ActiveRecord\City\City::class;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ActiveRecord\City\City
    {
        return $this->protectedGetById(self::getBasicActiveRecord(), $id);
    }
}