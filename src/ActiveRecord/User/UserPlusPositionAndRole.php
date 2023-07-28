<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\User;

use VetmanagerApiGateway\DTO\User\UserPlusPositionAndRoleDto;

final class UserPlusPositionAndRole extends AbstractUser
{
    public static function getDtoClass(): string
    {
        return UserPlusPositionAndRoleDto::class;
    }
}
