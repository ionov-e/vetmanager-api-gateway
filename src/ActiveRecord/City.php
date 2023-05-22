<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Enum\Completeness;
use VetmanagerApiGateway\ActiveRecord\Interface\AllRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllRequestsTrait;
use VetmanagerApiGateway\DTO\CityDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/**
 * @property CityDto $originalDto
 * @property positive-int $id
 * @property string $title
 * @property positive-int $typeId Default: 1
 * @property-read CityType $type
 * @property-read array{
 *     id: string,
 *     title: string,
 *     type_id: string
 * } $originalDataArray
 */
final class City extends AbstractActiveRecord implements AllRequestsInterface
{

    use AllRequestsTrait;

    /** @return ApiModel::City */
    public static function getApiModel(): ApiModel
    {
        return ApiModel::City;
    }

    public static function getCompletenessFromGetAllOrByQuery(): Completeness
    {
        return Completeness::Full;
    }

    /** @throws VetmanagerApiGatewayException
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'type' => CityType::getById($this->apiGateway, $this->typeId),
            default => $this->originalDto->$name,
        };
    }
}
