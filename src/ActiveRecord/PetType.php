<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Enum\Source;
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
 * @property array{
 *     id: string,
 *     title: string,
 *     picture: string,
 *     type: ?string,
 *     breeds: list<array{
 *              "id": string,
 *              "title": string,
 *              "pet_type_id": string,
 *          }
 *     >
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

    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        switch ($name) {
            case 'breeds':
                $this->fillCurrentObjectWithGetByIdDataIfItsNot();
                return Breed::fromMultipleDtosArrays($this->apiGateway, $this->originalDataArray['breeds'], Source::OnlyBasicDto);
            default:
                return $this->originalDto->$name;
        }
    }
}
