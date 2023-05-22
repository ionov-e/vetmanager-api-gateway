<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Enum\Completeness;
use VetmanagerApiGateway\ActiveRecord\Interface\AllRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllRequestsTrait;
use VetmanagerApiGateway\DTO\PetTypeDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/**
 * @property-read PetTypeDto $originalDto
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
final class PetType extends AbstractActiveRecord implements AllRequestsInterface
{
    use AllRequestsTrait;

    /** @return ApiModel::PetType */
    public static function getApiModel(): ApiModel
    {
        return ApiModel::PetType;
    }

    public static function getCompletenessFromGetAllOrByQuery(): Completeness
    {
        return Completeness::OnlyBasicDto;
    }

    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        switch ($name) {
            case 'breeds':
                $this->fillCurrentObjectWithGetByIdDataIfSourceIsNotFull();
                return Breed::fromMultipleDtosArrays($this->apiGateway, $this->originalDataArray['breeds'], Completeness::OnlyBasicDto);
            default:
                return $this->originalDto->$name;
        }
    }
}
