<?php

namespace VetmanagerApiGateway\Facade;

use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class Client extends AbstractFacade
{
    public static function getDefaultActiveRecord(): string
    {
        return ActiveRecord\Client::class;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ActiveRecord\ClientPlusTypeAndCity
    {
        return $this->protectedGetById($id, ActiveRecord\ClientPlusTypeAndCity::class);
    }
}