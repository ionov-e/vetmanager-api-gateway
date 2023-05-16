<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\DTO\CityDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/** @property-read CityDto $originalDto
 * @property positive-int id
 * @property string title
 * @property positive-int typeId Default: 1
 * @property-read CityType type
 * @property array{
 *     "id": string,
 *     "title": string,
 *     "type_id": string,
 * } $originalData
 */
final class City extends AbstractActiveRecord implements AllGetRequestsInterface
{

    use AllGetRequestsTrait;

    /** @return ApiModel::City */
    public static function getApiModel(): ApiModel
    {
        return ApiModel::City;
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
