<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\User;

use VetmanagerApiGateway\DTO\User\UserOnlyDto;

final class UserOnly extends AbstractUser
{
    public static function getDtoClass(): string
    {
        return UserOnlyDto::class;
    }
}
