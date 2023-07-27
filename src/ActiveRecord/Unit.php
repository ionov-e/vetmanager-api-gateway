<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\DTO\Enum\Unit\Status;
use VetmanagerApiGateway\DTO\UnitDto;

/**
 * @property-read UnitDto $originalDto
 * @property int $id
 * @property string $title
 * @property Status $status Default: 'active'
 * @property-read array{
 *     id: numeric-string,
 *     title: string,
 *     status: string
 * } $originalDataArray
 */
final class Unit extends AbstractActiveRecord
{
//    public static function getCompletenessFromGetAllOrByQuery(): Completeness
//    {
//        return Completeness::Full;
//    }
}
