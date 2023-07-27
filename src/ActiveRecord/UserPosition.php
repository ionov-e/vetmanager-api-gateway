<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use DateInterval;
use VetmanagerApiGateway\DTO\UserPositionDto;

/**
 * @property-read UserPositionDto $originalDto
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
//    public static function getCompletenessFromGetAllOrByQuery(): Completeness
//    {
//        return Completeness::Full;
//    }
}
