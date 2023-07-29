<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Street;

use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecord\City\City;
use VetmanagerApiGateway\DTO\Street\StreetOnlyDto;
use VetmanagerApiGateway\DTO\Street\TypeEnum;

/**
 * @property-read StreetOnlyDto $originalDto
 * @property positive-int $id
 * @property string $title Default: ''
 * @property TypeEnum $type Default: 'street'
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
abstract class AbstractStreet extends AbstractActiveRecord
{
    public static function getRouteKey(): string
    {
        return 'street';
    }
//    /** @throws VetmanagerApiGatewayException */
//    public function __get(string $name): mixed
//    {
//        return match ($name) {
//            'city' => !empty($this->originalDataArray['city'])
//                ? City::fromSingleDtoArrayAsFromGetById($this->activeRecordFactory, $this->originalDataArray['city'])
//                : null,
//            default => $this->originalDto->$name,
//        };
//    }
}
