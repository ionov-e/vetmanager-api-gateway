<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Breed;

use VetmanagerApiGateway\ActiveRecord\PetType\AbstractPetType;
use VetmanagerApiGateway\DTO\Breed\BreedOnlyDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

final class BreedOnly extends AbstractBreed
{
    public static function getDtoClass(): string
    {
        return BreedOnlyDto::class;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getPetType(): AbstractPetType
    {
        return (new \VetmanagerApiGateway\Facade\PetType($this->activeRecordFactory))->getById($this->getPetTypeId());
    }
}
