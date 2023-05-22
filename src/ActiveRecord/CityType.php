<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Enum\Completeness;
use VetmanagerApiGateway\ActiveRecord\Interface\AllRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllRequestsTrait;
use VetmanagerApiGateway\DTO\CityTypeDto;

/**
 * @property-read CityTypeDto $originalDto
 * @property positive-int $id
 * @property string $title
 * @property-read array{
 *     id: string,
 *     title: string
 * } $originalDataArray
 */
final class CityType extends AbstractActiveRecord implements AllRequestsInterface
{
    use AllRequestsTrait;

    /** @return ApiModel::CityType */
    public static function getApiModel(): ApiModel
    {
        return ApiModel::CityType;
    }

    public static function getCompletenessFromGetAllOrByQuery(): Completeness
    {
        return Completeness::Full;
    }

    public function __get(string $name): mixed
    {
        return $this->originalDto->$name;
    }
}
