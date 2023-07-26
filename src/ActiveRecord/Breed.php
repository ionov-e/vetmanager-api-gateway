<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Enum\Completeness;
use VetmanagerApiGateway\ActiveRecord\Interface\AllRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllRequestsTrait;
use VetmanagerApiGateway\DTO\BreedDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/**
 * @property-read BreedDto $originalDto
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
 * @property-read PetType $type
 */
final class Breed extends AbstractActiveRecord implements AllRequestsInterface
{
    use AllRequestsTrait;

    /** @return ApiModel::Breed */
    public static function getApiModel(): ApiModel
    {
        return ApiModel::Breed;
    }

    public static function getCompletenessFromGetAllOrByQuery(): Completeness
    {
        return Completeness::OnlyBasicDto;
    }

    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'type' => ($this->completenessLevel == Completeness::Full)
                ? PetType::fromSingleDtoArrayUsingBasicDto($this->activeRecordFactory, $this->originalDataArray['petType'])
                : PetType::getById($this->activeRecordFactory, $this->typeId),
            default => $this->originalDto->$name,
        };
    }
}
