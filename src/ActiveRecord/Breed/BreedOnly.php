<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Breed;

use VetmanagerApiGateway\ActiveRecord\PetType\AbstractPetType;
use VetmanagerApiGateway\ActiveRecord\PetType\PetTypeOnly;
use VetmanagerApiGateway\DTO\Breed\BreedOnlyDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/**
 * @property-read BreedOnlyDto $originalDto
 * @property positive-int $id
 * @property non-empty-string $title
 * @property positive-int $typeId
 * @property array{
 *     id: string,
 *     title: string,
 *     pet_type_id: string,
 *     petType: array{
 *          id: string,
 *          title: string,
 *          picture: string,
 *          type?: string
 *      }
 * } $originalDataArray
 * @property-read PetTypeOnly $type
 */
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
