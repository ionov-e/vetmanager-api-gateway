<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Pet;

use VetmanagerApiGateway\DTO\Pet\PetOnlyDto;

class PetOnly extends AbstractPet
{
    public static function getDtoClass(): string
    {
        return PetOnlyDto::class;
    }
}
