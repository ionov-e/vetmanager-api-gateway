<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Pet;

use VetmanagerApiGateway\DTO\Pet\PetPlusOwnerAndTypeAndBreedAndColorDto;

class PetPlusOwnerAndTypeAndBreedAndColor extends AbstractPet
{
    public static function getDtoClass(): string
    {
        return PetPlusOwnerAndTypeAndBreedAndColorDto::class;
    }
}
