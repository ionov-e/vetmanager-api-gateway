<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use DateTime;
use VetmanagerApiGateway\DO\FullName;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Hydrator\ApiBool;
use VetmanagerApiGateway\Hydrator\ApiDateTime;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;
use VetmanagerApiGateway\Hydrator\DtoPropertyList;
use VetmanagerApiGateway\Hydrator\Enum\DtoPropertyMode;

/**
 * @property-read FullName $fullName
 */
final class UserDto extends AbstractDTO
{
    /** @var positive-int */
    public int $id;
    public string $lastName;
    public string $firstName;
    public string $middleName;
    public string $login;
    public string $password;
    /** @var positive-int */
    public int $positionId;
    public string $email;
    /** Default: '' */
    public string $phone;
    /** Default: '' */
    public string $cellPhone;
    public string $address;
    /** @var ?positive-int */
    public ?int $roleId;
    /** Default: 0 */
    public bool $isActive;
    /** Вообще не понимаю что означает. Default: 1 */
    public bool $isPercentCalculated;
    public string $nickname;
    /** Дата без времени */
    public ?DateTime $lastChangePwdDate;
    /** Default: 0 */
    public bool $isLimited;
    /** Разного вида строк приходят */
    public string $carrotquestId;
    /** Default: ''. Самые разные строки могут быть */
    public string $sipNumber;
    /** Default: '' */
    public string $userInn;

    /** @param array{
     *     "id": string,
     *     "last_name": string,
     *     "first_name": string,
     *     "middle_name": string,
     *     "login": string,
     *     "passwd": string,
     *     "position_id": string,
     *     "email": string,
     *     "phone": string,
     *     "cell_phone": string,
     *     "address": string,
     *     "role_id": ?string,
     *     "is_active": string,
     *     "calc_percents": string,
     *     "nickname": ?string,
     *     "last_change_pwd_date": string,
     *     "is_limited": string,
     *     "carrotquest_id": ?string,
     *     "sip_number": ?string,
     *     "user_inn": string,
     *     "position"?: array,
     *     "role"?: array
     * } $originalData
     * @throws VetmanagerApiGatewayException
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public static function fromApiResponseArray(array $originalData): self
    {
        $instance = new self();
        $instance->id = ApiInt::fromStringOrNull($originalData['id'])->positiveInt;
        $instance->lastName = ApiString::fromStringOrNull($originalData['last_name'])->string;
        $instance->firstName = ApiString::fromStringOrNull($originalData['first_name'])->string;
        $instance->middleName = ApiString::fromStringOrNull($originalData['middle_name'])->string;
        $instance->login = ApiString::fromStringOrNull($originalData['login'])->string;
        $instance->password = ApiString::fromStringOrNull($originalData['passwd'])->string;
        $instance->positionId = ApiInt::fromStringOrNull($originalData['position_id'])->positiveInt;
        $instance->email = ApiString::fromStringOrNull($originalData['email'])->string;
        $instance->phone = ApiString::fromStringOrNull($originalData['phone'])->string;
        $instance->cellPhone = ApiString::fromStringOrNull($originalData['cell_phone'])->string;
        $instance->address = ApiString::fromStringOrNull($originalData['address'])->string;
        $instance->roleId = ApiInt::fromStringOrNull($originalData['role_id'])->positiveIntOrNull;
        $instance->isActive = ApiBool::fromStringOrNull($originalData['is_active'])->bool;
        $instance->isPercentCalculated = ApiBool::fromStringOrNull($originalData['calc_percents'])->bool;
        $instance->nickname = ApiString::fromStringOrNull($originalData['nickname'])->string;
        $instance->lastChangePwdDate = ApiDateTime::fromOnlyDateString($originalData['last_change_pwd_date'])->dateTimeOrNull;
        $instance->isLimited = ApiBool::fromStringOrNull($originalData['is_limited'])->bool;
        $instance->carrotquestId = ApiString::fromStringOrNull($originalData['carrotquest_id'])->string;
        $instance->sipNumber = ApiString::fromStringOrNull($originalData['sip_number'])->string;
        $instance->userInn = ApiString::fromStringOrNull($originalData['user_inn'])->string;
        return $instance;
    }

    /** @inheritdoc */
    public function getRequiredKeysForPostArray(): array
    {
        return [];
    }

    /** @inheritdoc
     * @throws VetmanagerApiGatewayRequestException
     */
    protected function getSetValuesWithoutId(): array
    {
        return (new DtoPropertyList(
            $this,
            ['lastName', 'last_name'],
            ['firstName', 'first_name'],
            ['middleName', 'middle_name'],
            ['login', 'login'],
            ['password', 'passwd'],
            ['positionId', 'position_id'],
            ['email', 'email'],
            ['phone', 'phone'],
            ['cellPhone', 'cell_phone'],
            ['address', 'address'],
            ['roleId', 'role_id'],
            ['isActive', 'is_active'],
            ['isPercentCalculated', 'calc_percents'],
            ['nickname', 'nickname'],
            ['lastChangePwdDate', 'last_change_pwd_date', DtoPropertyMode::DateTimeOnlyDate],
            ['isLimited', 'is_limited'],
            ['carrotquestId', 'carrotquest_id'],
            ['sipNumber', 'sip_number'],
            ['userInn', 'user_inn'],
        ))->toArray();
    }
}
