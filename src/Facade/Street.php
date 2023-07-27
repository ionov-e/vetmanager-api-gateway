<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class Street extends AbstractFacade
{
    public static function getDefaultActiveRecord(): string
    {
        return ActiveRecord\Street::class;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ActiveRecord\Street
    {
        return $this->protectedGetById(ActiveRecord\Street::class, $id);
    }
}