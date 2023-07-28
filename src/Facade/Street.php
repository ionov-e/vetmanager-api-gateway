<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class Street extends AbstractFacade
{
    public static function getBasicActiveRecord(): string
    {
        return ActiveRecord\Street\StreetOnly::class;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ActiveRecord\Street\StreetOnly
    {
        return $this->protectedGetById(ActiveRecord\Street\StreetOnly::class, $id);
    }
}