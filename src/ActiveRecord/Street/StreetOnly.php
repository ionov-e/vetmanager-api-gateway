<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Street;

use VetmanagerApiGateway\ActiveRecord\City\City;
use VetmanagerApiGateway\DTO\Street\StreetOnlyDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

final class StreetOnly extends AbstractStreet
{
    public static function getDtoClass(): string
    {
        return StreetOnlyDto::class;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getCity(): City
    {
        return (new \VetmanagerApiGateway\Facade\City($this->activeRecordFactory))->getById($this->getCityId());
    }
}
