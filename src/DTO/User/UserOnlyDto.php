<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\User;

use DateTime;
use VetmanagerApiGateway\ApiDataInterpreter\ToBool;
use VetmanagerApiGateway\ApiDataInterpreter\ToDateTime;
use VetmanagerApiGateway\ApiDataInterpreter\ToInt;
use VetmanagerApiGateway\ApiDataInterpreter\ToString;
use VetmanagerApiGateway\DTO\AbstractDTO;

class UserOnlyDto extends AbstractDTO implements UserOnlyDtoInterface
{
    /**
     * @param string|null $id
     * @param string|null $last_name
     * @param string|null $first_name
     * @param string|null $middle_name
     * @param string|null $login
     * @param string|null $passwd
     * @param string|null $position_id
     * @param string|null $email
     * @param string|null $phone Default: ''
     * @param string|null $cell_phone Default: ''
     * @param string|null $address
     * @param string|null $role_id
     * @param string|null $is_active Default: 0
     * @param string|null $calc_percents Default:
     * @param string|null $nickname
     * @param string|null $youtrack_login Не должен существовать, но на тестовом есть
     * @param string|null $youtrack_password Не должен существовать, но на тестовом есть
     * @param string|null $last_change_pwd_date
     * @param string|null $is_limited Default: 0
     * @param string|null $carrotquest_id
     * @param string|null $sip_number
     * @param string|null $user_inn
     */
    public function __construct(
        protected ?string $id,
        protected ?string $last_name,
        protected ?string $first_name,
        protected ?string $middle_name,
        protected ?string $login,
        protected ?string $passwd,
        protected ?string $position_id,
        protected ?string $email,
        protected ?string $phone,
        protected ?string $cell_phone,
        protected ?string $address,
        protected ?string $role_id,
        protected ?string $is_active,
        protected ?string $calc_percents,
        protected ?string $nickname,
        protected ?string $youtrack_login = null,
        protected ?string $youtrack_password = null,
        protected ?string $last_change_pwd_date,
        protected ?string $is_limited,
        protected ?string $carrotquest_id,
        protected ?string $sip_number,
        protected ?string $user_inn
    )
    {
    }

    public function getId(): int
    {
        return ToInt::fromStringOrNull($this->id)->getPositiveIntOrThrow();
    }

    public function getLastName(): string
    {
        return ToString::fromStringOrNull($this->last_name)->getStringEvenIfNullGiven();
    }

    public function getFirstName(): string
    {
        return ToString::fromStringOrNull($this->first_name)->getStringEvenIfNullGiven();
    }

    public function getMiddleName(): string
    {
        return ToString::fromStringOrNull($this->middle_name)->getStringEvenIfNullGiven();
    }

    public function getLogin(): string
    {
        return ToString::fromStringOrNull($this->login)->getStringEvenIfNullGiven();
    }

    public function getPassword(): string
    {
        return ToString::fromStringOrNull($this->passwd)->getStringEvenIfNullGiven();
    }

    public function getPositionId(): int
    {
        return ToInt::fromStringOrNull($this->position_id)->getPositiveIntOrThrow();
    }

    public function getEmail(): string
    {
        return ToString::fromStringOrNull($this->email)->getStringEvenIfNullGiven();
    }

    public function getPhone(): string
    {
        return ToString::fromStringOrNull($this->phone)->getStringEvenIfNullGiven();
    }

    public function getCellPhone(): string
    {
        return ToString::fromStringOrNull($this->cell_phone)->getStringEvenIfNullGiven();
    }

    public function getAddress(): string
    {
        return ToString::fromStringOrNull($this->address)->getStringEvenIfNullGiven();
    }

    public function getRoleId(): ?int
    {
        return ToInt::fromStringOrNull($this->role_id)->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function getIsActive(): bool
    {
        return ToBool::fromStringOrNull($this->is_active)->getBoolOrThrowIfNull();
    }

    public function getIsPercentCalculated(): bool
    {
        return ToBool::fromStringOrNull($this->calc_percents)->getBoolOrThrowIfNull();
    }

    public function getNickname(): string
    {
        return ToString::fromStringOrNull($this->nickname)->getStringEvenIfNullGiven();
    }

    public function getYoutrackLogin(): string
    {
        return ToString::fromStringOrNull($this->youtrack_login)->getStringEvenIfNullGiven();
    }

    public function getYoutrackPassword(): string
    {
        return ToString::fromStringOrNull($this->youtrack_password)->getStringEvenIfNullGiven();
    }

    public function getLastChangePwdDateAsString(): ?string
    {
        return $this->last_change_pwd_date;
    }

    public function getLastChangePwdDateAsDateTime(): ?DateTime
    {
        return ToDateTime::fromOnlyDateString($this->last_change_pwd_date)->getDateTimeOrThrow();
    }

    public function getIsLimited(): bool
    {
        return ToBool::fromStringOrNull($this->is_limited)->getBoolOrThrowIfNull();
    }

    public function getCarrotQuestId(): string
    {
        return ToString::fromStringOrNull($this->carrotquest_id)->getStringEvenIfNullGiven();
    }

    public function getSipNumber(): string
    {
        return ToString::fromStringOrNull($this->sip_number)->getStringEvenIfNullGiven();
    }

    public function getUserInn(): string
    {
        return ToString::fromStringOrNull($this->user_inn)->getStringEvenIfNullGiven();
    }

    public function setLastName(string $value): static
    {
        return self::setPropertyFluently($this, 'last_name', $value);
    }

    public function setFirstName(string $value): static
    {
        return self::setPropertyFluently($this, 'first_name', $value);
    }

    public function setMiddleName(string $value): static
    {
        return self::setPropertyFluently($this, 'middle_name', $value);
    }

    public function setLogin(?string $value): static
    {
        return self::setPropertyFluently($this, 'login', $value);
    }

    public function setPasswd(?string $value): static
    {
        return self::setPropertyFluently($this, 'passwd', $value);
    }

    public function setPositionId(?int $value): static
    {
        return self::setPropertyFluently($this, 'position_id', is_null($value) ? null : (string)$value);
    }

    public function setEmail(?string $value): static
    {
        return self::setPropertyFluently($this, 'email', $value);
    }

    public function setPhone(?string $value): static
    {
        return self::setPropertyFluently($this, 'phone', $value);
    }

    public function setCellPhone(?string $value): static
    {
        return self::setPropertyFluently($this, 'cell_phone', $value);
    }

    public function setAddress(?string $value): static
    {
        return self::setPropertyFluently($this, 'address', $value);
    }

    public function setRoleId(?int $value): static
    {
        return self::setPropertyFluently($this, 'role_id', is_null($value) ? null : (string)$value);
    }

    public function setIsActive(?bool $value): static
    {
        return self::setPropertyFluently($this, 'is_active', is_null($value) ? null : (string)(int)$value);
    }

    public function setCalcPercents(?float $value): static
    {
        return self::setPropertyFluently($this, 'calc_percents', is_null($value) ? null : (string)$value);
    }

    public function setNickname(?string $value): static
    {
        return self::setPropertyFluently($this, 'nickname', $value);
    }

    public function setYoutrackLogin(?string $value): static
    {
        return self::setPropertyFluently($this, 'youtrack_login', $value);
    }

    public function setYoutrackPassword(?string $value): static
    {
        return self::setPropertyFluently($this, 'youtrack_password', $value);
    }

    public function setLastChangePwdDateFromString(?string $value): static
    {
        return self::setPropertyFluently($this, 'last_change_pwd_date', $value);
    }

    public function setLastChangePwdDateFromDateTime(DateTime $value): static
    {
        return self::setPropertyFluently($this, 'last_change_pwd_date', $value->format('Y-m-d H:i:s'));
    }

    public function setIsLimited(?bool $value): static
    {
        return self::setPropertyFluently($this, 'is_limited', is_null($value) ? null : (string)(int)$value);
    }

    public function setCarrotQuestId(?string $value): static
    {
        return self::setPropertyFluently($this, 'carrotquest_id', $value);
    }

    public function setSipNumber(?string $value): static
    {
        return self::setPropertyFluently($this, 'sip_number', $value);
    }

    public function setUserInn(?string $value): static
    {
        return self::setPropertyFluently($this, 'user_inn', $value);
    }

//    /** @param array{
//     *     "id": string,
//     *     "last_name": string,
//     *     "first_name": string,
//     *     "middle_name": string,
//     *     "login": string,
//     *     "passwd": string,
//     *     "position_id": string,
//     *     "email": string,
//     *     "phone": string,
//     *     "cell_phone": string,
//     *     "address": string,
//     *     "role_id": ?string,
//     *     "is_active": string,
//     *     "calc_percents": string,
//     *     "nickname": ?string,
//     *     "last_change_pwd_date": string,
//     *     "is_limited": string,
//     *     "carrotquest_id": ?string,
//     *     "sip_number": ?string,
//     *     "user_inn": string,
//     *     "position"?: array,
//     *     "role"?: array
//     * } $originalDataArray
//     */
}
