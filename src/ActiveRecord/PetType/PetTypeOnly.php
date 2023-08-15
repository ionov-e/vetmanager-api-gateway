<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\PetType;

use VetmanagerApiGateway\ActiveRecord\Breed\BreedPlusPetType;
use VetmanagerApiGateway\DTO\PetType\PetTypeOnlyDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade\Breed;

final class PetTypeOnly extends AbstractPetType
{
    public static function getDtoClass(): string
    {
        return PetTypeOnlyDto::class;
    }

    /**
     * @return BreedPlusPetType[]
     * @throws VetmanagerApiGatewayException
     */
    public function getBreeds(): array
    {
        return (new Breed($this->activeRecordFactory))->getByPetTypeId($this->getId());
    }
}
