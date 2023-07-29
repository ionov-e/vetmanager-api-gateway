<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\PetType;

use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\DTO\PetType\PetTypeOnlyDto;

/**
 * @property-read PetTypeOnlyDto $originalDto
 * @property positive-int id
 * @property string title
 * @property string picture
 * @property string type
 * @property-read array{
 *     id: string,
 *     title: string,
 *     picture: string,
 *     type: ?string,
 *     breeds: list<array{
 *              id: string,
 *              title: string,
 *              pet_type_id: string
 *          }>
 * } $originalDataArray 'breeds' массив только при GetById
 */
abstract class AbstractPetType extends AbstractActiveRecord
{
    public static function getRouteKey(): string
    {
        return 'petType';
    }

//    /** @throws VetmanagerApiGatewayException */
//    public function __get(string $name): mixed
//    {
//        switch ($name) {
//            case 'breeds':
//                $this->fillCurrentObjectWithGetByIdDataIfSourceIsNotFull();
//                return BreedOnly::fromMultipleDtosArrays($this->activeRecordFactory, $this->originalDataArray['breeds'], Completeness::OnlyBasicDto);
//            default:
//                return $this->originalDto->$name;
//        }
//    }
}
