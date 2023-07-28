<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Role;

use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\DTO\Role\RoleOnlyDto;

/**
 * @property-read RoleOnlyDto $originalDto
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
    public static function getRouteKey(): string
    {
        return 'role';
    }

    public static function getDtoClass(): string
    {
        return RoleOnlyDto::class;
    }
}
