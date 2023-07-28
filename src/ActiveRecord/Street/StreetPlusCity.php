<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Street;

use VetmanagerApiGateway\DTO\Street\StreetPlusCityDto;

final class StreetPlusCity extends AbstractStreet
{
    public static function getDtoClass(): string
    {
        return StreetPlusCityDto::class;
    }
}
