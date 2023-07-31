<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\User;

use DateTime;
use VetmanagerApiGateway\ApiDataInterpreter\DtoPropertyList;
use VetmanagerApiGateway\ApiDataInterpreter\Enum\DtoPropertyMode;
use VetmanagerApiGateway\ApiDataInterpreter\ToBool;
use VetmanagerApiGateway\ApiDataInterpreter\ToDateTime;
use VetmanagerApiGateway\ApiDataInterpreter\ToInt;
use VetmanagerApiGateway\ApiDataInterpreter\ToString;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;

class UserOnlyDto extends AbstractDTO
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
     * } $originalDataArray
     * @throws VetmanagerApiGatewayException
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public static function fromApiResponseArray(array $originalDataArray): self
    {
        $instance = new self($originalDataArray);
        $instance->id = ToInt::fromStringOrNull($originalDataArray['id'])->getPositiveInt();
        $instance->lastName = ToString::fromStringOrNull($originalDataArray['last_name'])->getStringEvenIfNullGiven();
        $instance->firstName = ToString::fromStringOrNull($originalDataArray['first_name'])->getStringEvenIfNullGiven();
        $instance->middleName = ToString::fromStringOrNull($originalDataArray['middle_name'])->getStringEvenIfNullGiven();
        $instance->login = ToString::fromStringOrNull($originalDataArray['login'])->getStringEvenIfNullGiven();
        $instance->password = ToString::fromStringOrNull($originalDataArray['passwd'])->getStringEvenIfNullGiven();
        $instance->positionId = ToInt::fromStringOrNull($originalDataArray['position_id'])->getPositiveInt();
        $instance->email = ToString::fromStringOrNull($originalDataArray['email'])->getStringEvenIfNullGiven();
        $instance->phone = ToString::fromStringOrNull($originalDataArray['phone'])->getStringEvenIfNullGiven();
        $instance->cellPhone = ToString::fromStringOrNull($originalDataArray['cell_phone'])->getStringEvenIfNullGiven();
        $instance->address = ToString::fromStringOrNull($originalDataArray['address'])->getStringEvenIfNullGiven();
        $instance->roleId = ToInt::fromStringOrNull($originalDataArray['role_id'])->getPositiveIntOrNull();
        $instance->isActive = ToBool::fromStringOrNull($originalDataArray['is_active'])->getBoolOrThrowIfNull();
        $instance->isPercentCalculated = ToBool::fromStringOrNull($originalDataArray['calc_percents'])->getBoolOrThrowIfNull();
        $instance->nickname = ToString::fromStringOrNull($originalDataArray['nickname'])->getStringEvenIfNullGiven();
        $instance->lastChangePwdDate = ToDateTime::fromOnlyDateString($originalDataArray['last_change_pwd_date'])->getDateTimeOrThrow();
        $instance->isLimited = ToBool::fromStringOrNull($originalDataArray['is_limited'])->getBoolOrThrowIfNull();
        $instance->carrotquestId = ToString::fromStringOrNull($originalDataArray['carrotquest_id'])->getStringEvenIfNullGiven();
        $instance->sipNumber = ToString::fromStringOrNull($originalDataArray['sip_number'])->getStringEvenIfNullGiven();
        $instance->userInn = ToString::fromStringOrNull($originalDataArray['user_inn'])->getStringEvenIfNullGiven();
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
