<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\UserPosition;

use DateInterval;
use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\DTO\UserPosition\UserPositionOnlyDto;

/**
 * @property-read UserPositionOnlyDto $originalDto
 * @property int $id
 * @property string $title
 * @property ?DateInterval $admissionLength Default: '00:30:00'
 * @property-read array{
 *     id: string,
 *     title: string,
 *     admission_length: string
 * } $originalDataArray
 */
final class UserPosition extends AbstractActiveRecord
{
    public static function getRouteKey(): string
    {
        return 'userPosition';
    }

    public static function getDtoClass(): string
    {
        return UserPositionOnlyDto::class;
    }
}
