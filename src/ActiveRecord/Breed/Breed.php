<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Breed;

use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecord\PetType\PetTypeOnly;
use VetmanagerApiGateway\DTO\Breed\BreedOnlyDto;

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
 * } $originalDataArray 'petType' массив только при GetById
 * @property-read PetTypeOnly $type
 */
final class Breed extends AbstractActiveRecord //implements AllRequestsInterface
{
    public static function getDtoClass(): string
    {
        return Breed::class;
    }

    public static function getRouteKey(): string
    {
        return 'breed';
    }

//    /** @throws VetmanagerApiGatewayException */
//    public function __get(string $name): mixed
//    {
//        return match ($name) {
//            'type' => ($this->completenessLevel == Completeness::Full)
//                ? PetType::fromSingleDtoArrayUsingBasicDto($this->activeRecordFactory, $this->originalDataArray['petType'])
//                : PetType::getById($this->activeRecordFactory, $this->typeId),
//            default => $this->originalDto->$name,
//        };
//    }
}
