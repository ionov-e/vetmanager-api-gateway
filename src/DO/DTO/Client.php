<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO\DTO;

use DateTime;
use Otis22\VetmanagerRestApi\Query\Builder;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\BoolContainer;
use VetmanagerApiGateway\DO\DateTimeContainer;
use VetmanagerApiGateway\DO\Enum;
use VetmanagerApiGateway\DO\Enum\ApiRoute;
use VetmanagerApiGateway\DO\Enum\Client\Status;
use VetmanagerApiGateway\DO\FloatContainer;
use VetmanagerApiGateway\DO\FullName;
use VetmanagerApiGateway\DO\IntContainer;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/**
 * @property-read DAO\Client self
 * @property-read FullName fullName
 * @property-read DAO\MedicalCardsByClient[] medcards
 * @property-read DAO\AdmissionFromGetAll[] admissions
 * @property-read DAO\Pet[] petsAlive
 * @property-read ?DAO\City city
 * @property-read ?DAO\Street street
 */
class Client extends AbstractDTO
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
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = IntContainer::fromStringOrNull($originalData['id'])->positiveInt;
        $this->address = StringContainer::fromStringOrNull($originalData['address'])->string;
        $this->homePhone = StringContainer::fromStringOrNull($originalData['home_phone'])->string;
        $this->workPhone = StringContainer::fromStringOrNull($originalData['work_phone'])->string;
        $this->note = StringContainer::fromStringOrNull($originalData['note'])->string;
        $this->typeId = IntContainer::fromStringOrNull($originalData['type_id'])->positiveIntOrNull;
        $this->howFind = IntContainer::fromStringOrNull($originalData['how_find'])->positiveIntOrNull;
        $this->balance = FloatContainer::fromStringOrNull($originalData['balance'])->float;
        $this->email = StringContainer::fromStringOrNull($originalData['email'])->string;
        $this->cityTitle = StringContainer::fromStringOrNull($originalData['city'])->string;
        $this->cityId = IntContainer::fromStringOrNull($originalData['city_id'])->positiveIntOrNull;
        $this->dateRegister = DateTimeContainer::fromFullDateTimeString($originalData['date_register'])->dateTimeOrNull;
        $this->cellPhone = StringContainer::fromStringOrNull($originalData['cell_phone'])->string;
        $this->zip = StringContainer::fromStringOrNull($originalData['zip'])->string;
        $this->registrationIndex = StringContainer::fromStringOrNull($originalData['registration_index'])->string;
        $this->isVip = BoolContainer::fromStringOrNull($originalData['vip'])->bool;
        $this->lastName = StringContainer::fromStringOrNull($originalData['last_name'])->string;
        $this->firstName = StringContainer::fromStringOrNull($originalData['first_name'])->string;
        $this->middleName = StringContainer::fromStringOrNull($originalData['middle_name'])->string;
        $this->status = Status::from($originalData['status']);
        $this->discount = IntContainer::fromStringOrNull($originalData['discount'])->int;
        $this->passportSeries = StringContainer::fromStringOrNull($originalData['passport_series'])->string;
        $this->labNumber = StringContainer::fromStringOrNull($originalData['lab_number'])->string;
        $this->streetId = IntContainer::fromStringOrNull($originalData['street_id'])->positiveIntOrNull;
        $this->apartment = StringContainer::fromStringOrNull($originalData['apartment'])->string;
        $this->isUnsubscribed = BoolContainer::fromStringOrNull($originalData['unsubscribe'])->bool;
        $this->isBlacklisted = BoolContainer::fromStringOrNull($originalData['in_blacklist'])->bool;
        $this->lastVisitDate = DateTimeContainer::fromFullDateTimeString($originalData['last_visit_date'])->dateTimeOrNull;
        $this->numberOfJournal = StringContainer::fromStringOrNull($originalData['number_of_journal'])->string;
        $this->phonePrefix = StringContainer::fromStringOrNull($originalData['phone_prefix'])->string;
    }

    /** @throws VetmanagerApiGatewayException
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'self' => DAO\Client::getById($this->apiGateway, $this->id),
            'admissions' => DAO\AdmissionFromGetAll::getByClientId($this->apiGateway, $this->id),
            'medcards' => DAO\MedicalCardsByClient::getByClientId($this->apiGateway, $this->id),
            'petsAlive' => $this->getPetsAlive(),
            'street' => $this->streetId ? DAO\Street::getById($this->apiGateway, $this->streetId) : null,
            'city' => $this->cityId ? DAO\City::getById($this->apiGateway, $this->cityId) : null,
            'fullName' => new FullName(
                $this->originalData['first_name'],
                $this->originalData['middle_name'],
                $this->originalData['last_name']
            ),
            default => $this->$name
        };
    }

    /** @return DAO\Pet[]
     * @throws VetmanagerApiGatewayException
     */
    private function getPetsAlive(): array
    {
        $pets = $this->apiGateway->getWithQueryBuilder(
            ApiRoute::Pet,
            (new Builder())
                ->where('owner_id', (string)$this->id)
                ->where('status', Enum\Pet\Status::Alive->value)
        );

        return DAO\Pet::fromResponse($this->apiGateway, $pets);
    }
}
