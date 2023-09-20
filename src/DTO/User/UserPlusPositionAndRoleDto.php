<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\User;

use VetmanagerApiGateway\DTO\Role\RoleOnlyDto;
use VetmanagerApiGateway\DTO\UserPosition\UserPositionOnlyDto;

final class UserPlusPositionAndRoleDto extends UserOnlyDto
{
    /**
     * @param int|null $id
     * @param string|null $last_name
     * @param string|null $first_name
     * @param string|null $middle_name
     * @param string|null $login
     * @param string|null $passwd
     * @param int|null $position_id
     * @param string|null $email
     * @param string|null $phone
     * @param string|null $cell_phone
     * @param string|null $address
     * @param int|null $role_id
     * @param int|null $is_active
     * @param int|null $calc_percents
     * @param string|null $nickname
     * @param string|null $youtrack_login
     * @param string|null $youtrack_password
     * @param string|null $last_change_pwd_date
     * @param int|null $is_limited
     * @param string|null $carrotquest_id
     * @param string|null $sip_number
     * @param string|null $user_inn
     * @param UserPositionOnlyDto $position
     * @param RoleOnlyDto|null $role
     */
    public function __construct(
        protected ?int    $id,
        protected ?string $last_name,
        protected ?string             $first_name,
        protected ?string             $middle_name,
        protected ?string             $login,
        protected ?string             $passwd,
        protected ?int                $position_id,
        protected ?string             $email,
        protected ?string             $phone,
        protected ?string             $cell_phone,
        protected ?string             $address,
        protected ?int                $role_id,
        protected ?int                $is_active,
        protected ?int                $calc_percents,
        protected ?string             $nickname,
        protected ?string             $youtrack_login,
        protected ?string             $youtrack_password,
        protected ?string             $last_change_pwd_date,
        protected ?int                $is_limited,
        protected ?string             $carrotquest_id,
        protected ?string             $sip_number,
        protected ?string             $user_inn,
        protected UserPositionOnlyDto $position,
        protected ?RoleOnlyDto        $role = null
    )
    {
        parent::__construct(
            $id,
            $last_name,
            $first_name,
            $middle_name,
            $login,
            $passwd,
            $position_id,
            $email,
            $phone,
            $cell_phone,
            $address,
            $role_id,
            $is_active,
            $calc_percents,
            $nickname,
            $youtrack_login,
            $youtrack_password,
            $last_change_pwd_date,
            $is_limited,
            $carrotquest_id,
            $sip_number,
            $user_inn
        );
    }

    /** Пока что не видел, чтобы здесь был null */
    public function getUserPositionOnlyDto(): UserPositionOnlyDto
    {
        return $this->position;
    }

    /** Точно бывает в БД что отсутствует у пользователя */
    public function getRoleOnlyDto(): ?RoleOnlyDto
    {
        return $this->role;
    }
}
