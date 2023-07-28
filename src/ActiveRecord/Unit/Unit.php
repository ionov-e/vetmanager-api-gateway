<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Unit;

use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\DTO\Unit\StatusEnum;
use VetmanagerApiGateway\DTO\Unit\UnitOnlyDto;

/**
 * @property-read UnitOnlyDto $originalDto
 * @property int $id
 * @property string $title
 * @property StatusEnum $status Default: 'active'
 * @property-read array{
 *     id: numeric-string,
 *     title: string,
 *     status: string
 * } $originalDataArray
 */
final class Unit extends AbstractActiveRecord
{
    public static function getRouteKey(): string
    {
        return 'unit';
    }

    public static function getDtoClass(): string
    {
        return UnitOnlyDto::class;
    }
}
