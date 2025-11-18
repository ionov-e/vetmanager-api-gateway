<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\User;

use VetmanagerApiGateway\ActiveRecord\Role\Role;
use VetmanagerApiGateway\ActiveRecord\UserPosition\UserPosition;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\User\UserPlusPositionAndRoleDto;

final class UserPlusPositionAndRole extends AbstractUser
{
    public static function getDtoClass(): string
    {
        return UserPlusPositionAndRoleDto::class;
    }


    public function __construct(ActiveRecordFactory $activeRecordFactory, UserPlusPositionAndRoleDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    public function getRole(): ?Role
    {
        return $this->modelDTO->getRoleOnlyDto() ?
            $this->activeRecordFactory->getFromSingleDto($this->modelDTO->getRoleOnlyDto(), Role::class)
            : null;
    }

    public function getUserPosition(): UserPosition
    {
        return $this->activeRecordFactory->getFromSingleDto($this->modelDTO->getUserPositionOnlyDto(), UserPosition::class);
    }
}
