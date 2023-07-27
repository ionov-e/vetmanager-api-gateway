<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\DTO\RoleDto;

/**
 * @property-read RoleDto $originalDto
 * @property positive-int $id
 * @property string $name
 * @property bool $isSuper Default: False
 * @property-read array{
 *     id: numeric-string,
 *     name: string,
 *     super: string
 * } $originalDataArray
 */
final class Role extends AbstractActiveRecord
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
