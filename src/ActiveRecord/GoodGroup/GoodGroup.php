<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\GoodGroup;

use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\DTO\GoodGroup\GoodGroupOnlyDto;

/**
 * @property-read GoodGroupOnlyDto $originalDto
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
class GoodGroup extends AbstractActiveRecord
{
    public static function getRouteKey(): string
    {
        return 'goodGroup';
    }

    public static function getDtoClass(): string
    {
        return GoodGroupOnlyDto::class;
    }
}
