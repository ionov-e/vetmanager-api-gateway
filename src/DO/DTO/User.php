<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO\DTO;

use DateTime;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\DateTimeContainer;
use VetmanagerApiGateway\DO\FullName;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/** @property-read \VetmanagerApiGateway\DO\DTO\DAO\PetType $self
 * @property-read FullName $fullName
 */
class User extends AbstractDTO
{
    public int $id;
    public string $lastName;
    public string $firstName;
    public string $middleName;
    public string $login;
    public string $password;
    public string $email;
    /** Default: '' */
    public string $phone;
    /** Default: '' */
    public string $cellPhone;
    public string $address;
    /** Default: 0 */
    public bool $isActive;
    /** Default: 1 */
    public int $calcPercents;
    public ?string $nickname;
    /** Default: '' */
    public string $youtrackLogin;
    /** Default: '' */
    public string $youtrackPassword;
    /** Дата без времени */
    public DateTime $lastChangePwdDate;
    /** Default: 0 */
    public bool $isLimited;
    public ?string $carrotquestId;
    /** Default: '' */
    public string $sipNumber;
    /** Default: '' */
    public string $userInn;
    /** @var array{
     *     "id": string,
     *     "last_name": string,
     *     "first_name": string,
     *     "middle_name": string,
     *     "login": string,
     *     "passwd": string,
     *     "position_id": ?string,
     *     "email": string,
     *     "phone": string,
     *     "cell_phone": string,
     *     "address": string,
     *     "role_id": ?string,
     *     "is_active": string,
     *     "calc_percents": string,
     *     "nickname": ?string ,
     *     "youtrack_login": string,
     *     "youtrack_password": string,
     *     "last_change_pwd_date": string,
     *     "is_limited": string,
     *     "carrotquest_id": ?string,
     *     "sip_number": string,
     *     "user_inn": string
     * } $originalData
     */
    protected readonly array $originalData;

    /** @throws VetmanagerApiGatewayException */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = (int)$this->originalData['id'];
        $this->lastName = (string)$this->originalData['last_name'];
        $this->firstName = (string)$this->originalData['first_name'];
        $this->middleName = (string)$this->originalData['middle_name'];
        $this->login = (string)$this->originalData['login'];
        $this->password = (string)$this->originalData['passwd'];
        $this->email = (string)$this->originalData['email'];
        $this->phone = (string)$this->originalData['phone'];
        $this->cellPhone = (string)$this->originalData['cell_phone'];
        $this->address = (string)$this->originalData['address'];
        $this->isActive = (bool)$this->originalData['is_active'];
        $this->calcPercents = (int)$this->originalData['calc_percents'];
        $this->nickname = $this->originalData['nickname'] ? (string)$this->originalData['nickname'] : null;
        $this->youtrackLogin = (string)$this->originalData['youtrack_login'];
        $this->youtrackPassword = (string)$this->originalData['youtrack_password'];
        $this->lastChangePwdDate = (DateTimeContainer::fromOnlyDateString($this->originalData['last_change_pwd_date']))->dateTimeNullable;
        $this->isLimited = (bool)$this->originalData['is_limited'];
        $this->carrotquestId = $this->originalData['carrotquest_id'] ? (string)$this->originalData['carrotquest_id'] : null;
        $this->sipNumber = (string)$this->originalData['sip_number'];
        $this->userInn = (string)$this->originalData['user_inn'];
    }

    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'self' => DAO\User::getById($this->apiGateway, $this->id),
            'fullName' => new FullName($this->originalData['first_name'], $this->originalData['middle_name'], $this->originalData['last_name']),
            default => $this->$name,
        };
    }
}
