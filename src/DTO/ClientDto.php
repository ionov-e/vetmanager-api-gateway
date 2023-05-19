<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use DateTime;
use VetmanagerApiGateway\DO\FullName;
use VetmanagerApiGateway\DTO\Enum\Client\Status;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Hydrator\ApiBool;
use VetmanagerApiGateway\Hydrator\ApiDateTime;
use VetmanagerApiGateway\Hydrator\ApiFloat;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;

/**
 * @property-read FullName fullName
 * @property-read MedicalCardsByClient[] medcards
 * @property-read Admission[] admissions
 * @property-read Pet[] petsAlive
 * @property-read ?City city
 * @property-read ?Street street
 */
final class ClientDto extends AbstractDTO
{
    /** @var positive-int */
    public int $id;
    public string $address;
    public string $homePhone;
    public string $workPhone;
    public string $note;
    /** @var ?positive-int */
    public ?int $typeId;
    /** @var ?positive-int */
    public ?int $howFind;
    /** Default: '0.0000000000' */
    public float $balance;
    /** Default: '' */
    public string $email;
    public string $cityTitle;
    /** @var ?positive-int */
    public ?int $cityId;
    /** В БД бывает дефолтное значение: '0000-00-00 00:00:00' - переводится в null */
    public ?DateTime $dateRegister;
    public string $cellPhone;
    public string $zip;
    public string $registrationIndex;
    /** Default: 0 */
    public bool $isVip;
    public string $lastName;
    public string $firstName;
    public string $middleName;
    /** Default: Active */
    public Status $status;
    /** Default: 0 */
    public int $discount;
    public string $passportSeries;
    public string $labNumber;
    /** @var ?positive-int Default: 0 */
    public ?int $streetId;
    /** Default: '' */
    public string $apartment;
    /** Default: 0 */
    public bool $isUnsubscribed;
    /** Default: 0 */
    public bool $isBlacklisted;
    /** В БД бывает дефолтное значение: '0000-00-00 00:00:00' - переводится в null */
    public ?DateTime $lastVisitDate;
    /** Default: '' */
    public string $numberOfJournal;
    public string $phonePrefix;

    /** @param array{
     *      "id": string,
     *      "address": string,
     *      "home_phone": string,
     *      "work_phone": string,
     *      "note": string,
     *      "type_id": ?string,
     *      "how_find": ?string,
     *      "balance": string,
     *      "email": string,
     *      "city": string,
     *      "city_id": ?string,
     *      "date_register": string,
     *      "cell_phone": string,
     *      "zip": string,
     *      "registration_index": ?string,
     *      "vip": string,
     *      "last_name": string,
     *      "first_name": string,
     *      "middle_name": string,
     *      "status": string,
     *      "discount": string,
     *      "passport_series": string,
     *      "lab_number": string,
     *      "street_id": string,
     *      "apartment": string,
     *      "unsubscribe": string,
     *      "in_blacklist": string,
     *      "last_visit_date": string,
     *      "number_of_journal": string,
     *      "phone_prefix": ?string,
     *      "city_data"?: array,
     *      "client_type_data"?: array,
     * } $originalData
     * @throws VetmanagerApiGatewayException
     */
    public function __construct(array $originalData)
    {
        $this->id = ApiInt::fromStringOrNull($originalData['id'])->positiveInt;
        $this->address = ApiString::fromStringOrNull($originalData['address'])->string;
        $this->homePhone = ApiString::fromStringOrNull($originalData['home_phone'])->string;
        $this->workPhone = ApiString::fromStringOrNull($originalData['work_phone'])->string;
        $this->note = ApiString::fromStringOrNull($originalData['note'])->string;
        $this->typeId = ApiInt::fromStringOrNull($originalData['type_id'])->positiveIntOrNull;
        $this->howFind = ApiInt::fromStringOrNull($originalData['how_find'])->positiveIntOrNull;
        $this->balance = ApiFloat::fromStringOrNull($originalData['balance'])->float;
        $this->email = ApiString::fromStringOrNull($originalData['email'])->string;
        $this->cityTitle = ApiString::fromStringOrNull($originalData['city'])->string;
        $this->cityId = ApiInt::fromStringOrNull($originalData['city_id'])->positiveIntOrNull;
        $this->dateRegister = ApiDateTime::fromFullDateTimeString($originalData['date_register'])->dateTimeOrNull;
        $this->cellPhone = ApiString::fromStringOrNull($originalData['cell_phone'])->string;
        $this->zip = ApiString::fromStringOrNull($originalData['zip'])->string;
        $this->registrationIndex = ApiString::fromStringOrNull($originalData['registration_index'])->string;
        $this->isVip = ApiBool::fromStringOrNull($originalData['vip'])->bool;
        $this->lastName = ApiString::fromStringOrNull($originalData['last_name'])->string;
        $this->firstName = ApiString::fromStringOrNull($originalData['first_name'])->string;
        $this->middleName = ApiString::fromStringOrNull($originalData['middle_name'])->string;
        $this->status = Status::from($originalData['status']);
        $this->discount = ApiInt::fromStringOrNull($originalData['discount'])->int;
        $this->passportSeries = ApiString::fromStringOrNull($originalData['passport_series'])->string;
        $this->labNumber = ApiString::fromStringOrNull($originalData['lab_number'])->string;
        $this->streetId = ApiInt::fromStringOrNull($originalData['street_id'])->positiveIntOrNull;
        $this->apartment = ApiString::fromStringOrNull($originalData['apartment'])->string;
        $this->isUnsubscribed = ApiBool::fromStringOrNull($originalData['unsubscribe'])->bool;
        $this->isBlacklisted = ApiBool::fromStringOrNull($originalData['in_blacklist'])->bool;
        $this->lastVisitDate = ApiDateTime::fromFullDateTimeString($originalData['last_visit_date'])->dateTimeOrNull;
        $this->numberOfJournal = ApiString::fromStringOrNull($originalData['number_of_journal'])->string;
        $this->phonePrefix = ApiString::fromStringOrNull($originalData['phone_prefix'])->string;
    }
}
