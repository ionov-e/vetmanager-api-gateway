<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\DTO\CityTypeDto;

/** @property-read CityTypeDto $originalDto
 * @property positive-int id
 * @property string title
 * @property array{
 *     "id": string,
 *     "title": string,
 * } $originalDataArray
 */
final class CityType extends AbstractActiveRecord implements AllGetRequestsInterface
{
    use AllGetRequestsTrait;

    /** @return ApiModel::CityType */
    public static function getApiModel(): ApiModel
    {
        return ApiModel::CityType;
    }

    public function __get(string $name): mixed
    {
        return $this->originalDto->$name;
    }
}
