<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO\DTO;

use DateTime;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\BoolContainer;
use VetmanagerApiGateway\DO\DateTimeContainer;
use VetmanagerApiGateway\DO\DTO\DAO;
use VetmanagerApiGateway\DO\FullName;
use VetmanagerApiGateway\DO\IntContainer;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/** @property-read DAO\PetType $self
 * @property-read FullName $fullName
 */
class User extends AbstractDTO
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
    public DateTime $lastChangePwdDate;
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
     *     "nickname": ?string ,
     *     "last_change_pwd_date": string,
     *     "is_limited": string,
     *     "carrotquest_id": ?string,
     *     "sip_number": ?string,
     *     "user_inn": string
     * } $originalData
     * @throws VetmanagerApiGatewayException
     */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = IntContainer::fromStringOrNull($this->originalData['id'])->positiveInt;
        $this->lastName = StringContainer::fromStringOrNull($this->originalData['last_name'])->string;
        $this->firstName = StringContainer::fromStringOrNull($this->originalData['first_name'])->string;
        $this->middleName = StringContainer::fromStringOrNull($this->originalData['middle_name'])->string;
        $this->login = StringContainer::fromStringOrNull($this->originalData['login'])->string;
        $this->password = StringContainer::fromStringOrNull($this->originalData['passwd'])->string;
        $this->positionId = IntContainer::fromStringOrNull($this->originalData['position_id'])->positiveInt;
        $this->email = StringContainer::fromStringOrNull($this->originalData['email'])->string;
        $this->phone = StringContainer::fromStringOrNull($this->originalData['phone'])->string;
        $this->cellPhone = StringContainer::fromStringOrNull($this->originalData['cell_phone'])->string;
        $this->address = StringContainer::fromStringOrNull($this->originalData['address'])->string;
        $this->roleId = IntContainer::fromStringOrNull($this->originalData['role_id'])->positiveIntOrNull;
        $this->isActive = BoolContainer::fromStringOrNull($this->originalData['is_active'])->bool;
        $this->isPercentCalculated = BoolContainer::fromStringOrNull($this->originalData['calc_percents'])->bool;
        $this->nickname = StringContainer::fromStringOrNull($this->originalData['nickname'])->string;
        $this->lastChangePwdDate = DateTimeContainer::fromOnlyDateString($this->originalData['last_change_pwd_date'])->dateTime;
        $this->isLimited = BoolContainer::fromStringOrNull($this->originalData['is_limited'])->bool;
        $this->carrotquestId = StringContainer::fromStringOrNull($this->originalData['carrotquest_id'])->string;
        $this->sipNumber = StringContainer::fromStringOrNull($this->originalData['sip_number'])->string;
        $this->userInn = StringContainer::fromStringOrNull($this->originalData['user_inn'])->string;
    }

    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'self' => DAO\User::getById($this->apiGateway, $this->id),
            'fullName' => new FullName(
                $this->originalData['first_name'],
                $this->originalData['middle_name'],
                $this->originalData['last_name']
            ),
            default => $this->$name,
        };
    }
}
