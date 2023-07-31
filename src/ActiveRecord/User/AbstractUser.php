<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\User;

use DateTime;
use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecord\Role\Role;
use VetmanagerApiGateway\ActiveRecord\UserPosition\UserPosition;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DO\FullName;
use VetmanagerApiGateway\DTO\User\UserOnlyDto;
use VetmanagerApiGateway\DTO\User\UserOnlyDtoInterface;

/**
 * @property-read UserOnlyDto $originalDto
 * @property positive-int $id
 * @property string $lastName
 * @property string $firstName
 * @property string $middleName
 * @property string $login
 * @property string $password
 * @property positive-int $positionId
 * @property string $email
 * @property string $phone Default: ''
 * @property string $cellPhone Default: ''
 * @property string $address
 * @property ?positive-int $roleId
 * @property bool $isActive
 * @property bool $isPercentCalculated Вообще не понимаю что означает. Default: True
 * @property string $nickname
 * @property ?DateTime $lastChangePwdDate Дата без времени
 * @property bool $isLimited Default: 0
 * @property string $carrotquestId Разного вида строк приходят
 * @property string $sipNumber Default: ''. Самые разные строки могут быть
 * @property string $userInn Default: ''
 * @property-read array{
 *     id: string,
 *     last_name: string,
 *     first_name: string,
 *     middle_name: string,
 *     login: string,
 *     passwd: string,
 *     position_id: string,
 *     email: string,
 *     phone: string,
 *     cell_phone: string,
 *     address: string,
 *     role_id: ?string,
 *     is_active: string,
 *     calc_percents: string,
 *     nickname: ?string,
 *     last_change_pwd_date: string,
 *     is_limited: string,
 *     carrotquest_id: ?string,
 *     sip_number: ?string,
 *     user_inn: string,
 *     position?: array{
 *           id: string,
 *           title: string,
 *           admission_length: string
 *     },
 *     role?: array{
 *           id: string,
 *           name: string,
 *           super: string
 *     }
 * } $originalDataArray
 * @property-read ?Role $role
 * @property-read ?UserPosition $position
 */
abstract class AbstractUser extends AbstractActiveRecord implements UserOnlyDtoInterface
{
    public static function getRouteKey(): string
    {
        return 'user';
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, UserOnlyDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    /** @inheritDoc */
    public function getId(): int
    {
        return $this->modelDTO->getId();
    }

    public function getLastName(): string
    {
        return $this->modelDTO->getLastName();
    }

    public function getFirstName(): string
    {
        return $this->modelDTO->getFirstName();
    }

    public function getMiddleName(): string
    {
        return $this->modelDTO->getMiddleName();
    }

    public function getLogin(): string
    {
        return $this->modelDTO->getLogin();
    }

    public function getPassword(): string
    {
        return $this->modelDTO->getPassword();
    }

    /** @inheritDoc */
    public function getPositionId(): int
    {
        return $this->modelDTO->getPositionId();
    }

    public function getEmail(): string
    {
        return $this->modelDTO->getEmail();
    }

    public function getPhone(): string
    {
        return $this->modelDTO->getPhone();
    }

    public function getCellPhone(): string
    {
        return $this->modelDTO->getCellPhone();
    }

    public function getAddress(): string
    {
        return $this->modelDTO->getAddress();
    }

    /** @inheritDoc */
    public function getRoleId(): ?int
    {
        return $this->modelDTO->getRoleId();
    }

    /** @inheritDoc */
    public function getIsActive(): bool
    {
        return $this->modelDTO->getIsActive();
    }

    /** @inheritDoc */
    public function getIsPercentCalculated(): bool
    {
        return $this->modelDTO->getIsPercentCalculated();
    }

    public function getNickname(): string
    {
        return $this->modelDTO->getNickname();
    }

    /** @inheritDoc */
    public function getYoutrackLogin(): string
    {
        return $this->modelDTO->getYoutrackLogin();
    }

    /** @inheritDoc */
    public function getYoutrackPassword(): string
    {
        return $this->modelDTO->getYoutrackPassword();
    }

    /** @inheritDoc */
    public function getLastChangePwdDateAsString(): ?string
    {
        return $this->modelDTO->getLastChangePwdDateAsString();
    }

    /** @inheritDoc */
    public function getLastChangePwdDateAsDateTime(): ?DateTime
    {
        return $this->modelDTO->getLastChangePwdDateAsDateTime();
    }

    /** @inheritDoc */
    public function getIsLimited(): bool
    {
        return $this->modelDTO->getIsLimited();
    }

    /** @inheritDoc */
    public function getCarrotquestId(): string
    {
        return $this->modelDTO->getCarrotquestId();
    }

    /** @inheritDoc */
    public function getSipNumber(): string
    {
        return $this->modelDTO->getSipNumber();
    }

    /** @inheritDoc */
    public function getUserInn(): string
    {
        return $this->modelDTO->getUserInn();
    }

    /** @inheritDoc */
    public function setId(int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setId($value));
    }

    /** @inheritDoc */
    public function setLastName(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setLastName($value));
    }

    /** @inheritDoc */
    public function setFirstName(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setFirstName($value));
    }

    /** @inheritDoc */
    public function setMiddleName(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setMiddleName($value));
    }

    /** @inheritDoc */
    public function setLogin(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setLogin($value));
    }

    /** @inheritDoc */
    public function setPasswd(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setPasswd($value));
    }

    /** @inheritDoc */
    public function setPositionId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setPositionId($value));
    }

    /** @inheritDoc */
    public function setEmail(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setEmail($value));
    }

    public function setPhone(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setPhone($value));
    }

    public function setCellPhone(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setCellPhone($value));
    }

    /** @inheritDoc */
    public function setAddress(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setAddress($value));
    }

    /** @inheritDoc */
    public function setRoleId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setRoleId($value));
    }

    /** @inheritDoc */
    public function setIsActive(?bool $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setIsActive($value));
    }

    /** @inheritDoc */
    public function setCalcPercents(?float $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setCalcPercents($value));
    }

    /** @inheritDoc */
    public function setNickname(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setNickname($value));
    }

    /** @inheritDoc */
    public function setYoutrackLogin(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setYoutrackLogin($value));
    }

    /** @inheritDoc */
    public function setYoutrackPassword(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setYoutrackPassword($value));
    }

    /** @inheritDoc */
    public function setLastChangePwdDateAsString(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setLastChangePwdDateAsString($value));
    }

    /** @inheritDoc */
    public function setLastChangePwdDateAsDateTime(DateTime $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setLastChangePwdDateAsDateTime($value));
    }

    /** @inheritDoc */
    public function setIsLimited(?bool $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setIsLimited($value));
    }

    /** @inheritDoc */
    public function setCarrotquestId(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setCarrotquestId($value));
    }

    /** @inheritDoc */
    public function setSipNumber(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setSipNumber($value));
    }

    /** @inheritDoc */
    public function setUserInn(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setUserInn($value));
    }

    public function getFullName(): FullName
    {
        return new FullName($this->getFirstName(), $this->getMiddleName(), $this->getLastName());
    }

    abstract function getRole(): ?Role;

    abstract function getUserPosition(): UserPosition;
}
