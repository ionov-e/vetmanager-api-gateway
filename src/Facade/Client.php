<?php
declare(strict_types=1);

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
        return $this->protectedGetById(ActiveRecord\ClientPlusTypeAndCity::class, $id);
    }
}