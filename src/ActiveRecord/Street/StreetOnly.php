<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Street;

use VetmanagerApiGateway\DTO\Street\StreetOnlyDto;

final class StreetOnly extends AbstractStreet
{
    public static function getDtoClass(): string
    {
        return StreetOnlyDto::class;
    }
}
