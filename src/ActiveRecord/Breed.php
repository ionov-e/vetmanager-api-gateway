<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Enum\Source;
use VetmanagerApiGateway\ActiveRecord\Interface\AllRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllRequestsTrait;
use VetmanagerApiGateway\DTO\BreedDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/**
 * @property-read BreedDto $originalDto
 * @property positive-int id
 * @property non-empty-string title
 * @property positive-int typeId
 * @property-read PetType type
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
 * } $originalData 'petType' массив только при GetById
 */
final class Breed extends AbstractActiveRecord implements AllRequestsInterface
{
    use AllRequestsTrait;

    /** @return ApiModel::Breed */
    public static function getApiModel(): ApiModel
    {
        return ApiModel::Breed;
    }

    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'type' => ($this->sourceOfData == Source::GetById)
                ? PetType::fromSingleDtoArrayUsingBasicDto($this->apiGateway, $this->originalData['petType'])
                : PetType::getById($this->apiGateway, $this->originalDto->typeId),
            default => $this->originalDto->$name,
        };
    }
}
