<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\User;

use VetmanagerApiGateway\ActiveRecord\Role\Role;
use VetmanagerApiGateway\ActiveRecord\UserPosition\UserPosition;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\User\UserOnlyDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade;

final class UserOnly extends AbstractUser
{
    public static function getDtoClass(): string
    {
        return UserOnlyDto::class;
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, UserOnlyDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getRole(): ?Role
    {
        return $this->modelDTO->getRoleId() ?
            (new Facade\Role($this->activeRecordFactory))->getById($this->getRoleId())
            : null;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getUserPosition(): UserPosition
    {
        return (new Facade\UserPosition($this->activeRecordFactory))->getById($this->getPositionId());
    }
}
