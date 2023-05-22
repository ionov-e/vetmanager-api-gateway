<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Enum\Completeness;
use VetmanagerApiGateway\ActiveRecord\Interface\AllRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllRequestsTrait;
use VetmanagerApiGateway\DTO\Enum\Street\Type;
use VetmanagerApiGateway\DTO\StreetDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/**
 * @property-read StreetDto $originalDto
 * @property positive-int $id
 * @property string $title Default: ''
 * @property Type $type Default: 'street'
 * @property positive-int $cityId
 * @property-read array{
 *     id: string,
 *     title: string,
 *     city_id: string,
 *     type: string,
 *     city?: array{
 *              id: string,
 *              title: ?string,
 *              type_id: ?string
 *     }
 * } $originalDataArray
 * @property-read ?City $city
 */
final class Street extends AbstractActiveRecord implements AllRequestsInterface
{

    use AllRequestsTrait;

    /** @return ApiModel::Street */
    public static function getApiModel(): ApiModel
    {
        return ApiModel::Street;
    }

    public static function getCompletenessFromGetAllOrByQuery(): Completeness
    {
        return Completeness::Full;
    }

    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'city' => !empty($this->originalDataArray['city'])
                ? City::fromSingleDtoArrayAsFromGetById($this->apiGateway, $this->originalDataArray['city'])
                : null,
            default => $this->originalDto->$name,
        };
    }
}
