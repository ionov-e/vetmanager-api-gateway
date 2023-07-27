<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\DTO\GoodGroupDto;

/**
 * @property-read GoodGroupDto $originalDto
 * @property string $title
 * @property ?int $priceId
 * @property bool $isService Default: false
 * @property ?float $markup
 * @property bool $isShowInVaccines Default: false
 * @property-read array{
 *     id: string,
 *     title: string,
 *     is_service: string,
 *     markup: ?string,
 *     is_show_in_vaccines: string,
 *     price_id: ?string
 * } $originalDataArray
 */
final class GoodGroup extends AbstractActiveRecord
{

//    public static function getCompletenessFromGetAllOrByQuery(): Completeness
//    {
//        return Completeness::Full;
//    }

    public function __get(string $name): mixed
    {
        return $this->originalDto->$name;
    }
}
