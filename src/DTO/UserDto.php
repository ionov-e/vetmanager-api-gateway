<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use DateTime;
use VetmanagerApiGateway\DO\FullName;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Hydrator\ApiBool;
use VetmanagerApiGateway\Hydrator\ApiDateTime;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;

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
     */
    public function __construct(array $originalData)
    {
        $this->id = ApiInt::fromStringOrNull($originalData['id'])->positiveInt;
        $this->lastName = ApiString::fromStringOrNull($originalData['last_name'])->string;
        $this->firstName = ApiString::fromStringOrNull($originalData['first_name'])->string;
        $this->middleName = ApiString::fromStringOrNull($originalData['middle_name'])->string;
        $this->login = ApiString::fromStringOrNull($originalData['login'])->string;
        $this->password = ApiString::fromStringOrNull($originalData['passwd'])->string;
        $this->positionId = ApiInt::fromStringOrNull($originalData['position_id'])->positiveInt;
        $this->email = ApiString::fromStringOrNull($originalData['email'])->string;
        $this->phone = ApiString::fromStringOrNull($originalData['phone'])->string;
        $this->cellPhone = ApiString::fromStringOrNull($originalData['cell_phone'])->string;
        $this->address = ApiString::fromStringOrNull($originalData['address'])->string;
        $this->roleId = ApiInt::fromStringOrNull($originalData['role_id'])->positiveIntOrNull;
        $this->isActive = ApiBool::fromStringOrNull($originalData['is_active'])->bool;
        $this->isPercentCalculated = ApiBool::fromStringOrNull($originalData['calc_percents'])->bool;
        $this->nickname = ApiString::fromStringOrNull($originalData['nickname'])->string;
        $this->lastChangePwdDate = ApiDateTime::fromOnlyDateString($originalData['last_change_pwd_date'])->dateTimeOrNull;
        $this->isLimited = ApiBool::fromStringOrNull($originalData['is_limited'])->bool;
        $this->carrotquestId = ApiString::fromStringOrNull($originalData['carrotquest_id'])->string;
        $this->sipNumber = ApiString::fromStringOrNull($originalData['sip_number'])->string;
        $this->userInn = ApiString::fromStringOrNull($originalData['user_inn'])->string;
    }
}
