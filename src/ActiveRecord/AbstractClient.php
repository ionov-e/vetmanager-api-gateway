<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use DateTime;
use VetmanagerApiGateway\ActiveRecord\Trait\AllRequestsTrait;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\FullName;
use VetmanagerApiGateway\DTO\ClientDto;
use VetmanagerApiGateway\DTO\ClientDtoInterface;
use VetmanagerApiGateway\DTO\Enum;
use VetmanagerApiGateway\DTO\Enum\Client\Status;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/**
 * @property-read ClientDto $originalDto
 * @property positive-int $id
 * @property string $address
 * @property string $homePhone
 * @property string $workPhone
 * @property string $note
 * @property ?positive-int $typeId
 * @property ?positive-int $howFind
 * @property float $balance Default: '0.0000000000'
 * @property string $email Default: ''
 * @property string $cityTitle
 * @property ?positive-int $cityId
 * @property ?DateTime $dateRegister
 * @property string $cellPhone
 * @property string $zip
 * @property string $registrationIndex
 * @property bool $isVip Default: False
 * @property string $lastName
 * @property string $firstName
 * @property string $middleName
 * @property Enum\Client\Status $status Default: Active
 * @property int $discount Default: 0
 * @property string $passportSeries
 * @property string $labNumber
 * @property ?int $streetId
 * @property string $apartment Default: ''
 * @property bool $isUnsubscribed Default: False
 * @property bool $isBlacklisted Default: False
 * @property ?DateTime $lastVisitDate В БД бывает дефолтное значение: '0000-00-00 00:00:00' - переводится в null
 * @property string $numberOfJournal Default: ''
 * @property string $phonePrefix
 * @property-read  array{
 *   id: string,
 *   address: string,
 *   home_phone: string,
 *   work_phone: string,
 *   note: string,
 *   type_id: ?string,
 *   how_find: ?string,
 *   balance: string,
 *   email: string,
 *   city: string,
 *   city_id: ?string,
 *   date_register: string,
 *   cell_phone: string,
 *   zip: string,
 *   registration_index: ?string,
 *   vip: string,
 *   last_name: string,
 *   first_name: string,
 *   middle_name: string,
 *   status: string,
 *   discount: string,
 *   passport_series: string,
 *   lab_number: string,
 *   street_id: string,
 *   apartment: string,
 *   unsubscribe: string,
 *   in_blacklist: string,
 *   last_visit_date: string,
 *   number_of_journal: string,
 *   phone_prefix: ?string,
 *   city_data?: array {
 *      id: string,
 *      title: string,
 *      type_id: string
 *      },
 *   client_type_data?: array {
 *      id: string,
 *      title: string
 *      }
 * } $originalDataArray
 * @property-read ?City $city
 * @property-read string $typeTitle
 * @property-read Admission[] $admissions
 * @property-read MedicalCardByClient[] $medicalCards
 * @property-read Pet[] $petsAlive
 * @property-read ?Street $street
 * @property-read FullName $fullName
 * */
abstract class AbstractClient extends AbstractActiveRecord implements ClientDtoInterface//, AllRequestsInterface
{
    use AllRequestsTrait;

    public function __construct(ApiGateway $apiGateway, ClientDto $modelDTO)
    {
        parent::__construct($apiGateway, $modelDTO);
        $this->apiGateway = $apiGateway;
        $this->modelDTO = $modelDTO;
    }

    public static function getRouteKey(): string
    {
        return 'client';
    }

//    public static function getCompletenessFromGetAllOrByQuery(): Completeness     #TODO
//    {
//        return Completeness::Full;
//    }

    /** @inheritDoc */
    public function getId(): int
    {
        return $this->modelDTO->getId();
    }

    /** @inheritDoc */
    public function setId(int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setId($value));
    }

    public function getAddress(): string
    {
        return $this->modelDTO->getAddress();
    }

    /** @inheritDoc */
    public function setAddress(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setAddress($value));
    }

    public function getHomePhone(): string
    {
        return $this->modelDTO->getHomePhone();
    }

    /** @inheritDoc */
    public function setHomePhone(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setHomePhone($value));
    }

    public function getWorkPhone(): string
    {
        return $this->modelDTO->getWorkPhone();
    }

    /** @inheritDoc */
    public function setWorkPhone(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setWorkPhone($value));
    }

    public function getNote(): string
    {
        return $this->modelDTO->getNote();
    }

    /** @inheritDoc */
    public function setNote(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setNote($value));
    }

    /** @inheritDoc */
    public function getTypeId(): ?int
    {
        return $this->modelDTO->getTypeId();
    }

    /** @inheritDoc */
    public function setTypeId(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setTypeId($value));
    }

    /** @inheritDoc */
    public function getHowFind(): ?int
    {
        return $this->modelDTO->getHowFind();
    }

    /** @inheritDoc */
    public function setHowFind(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setHowFind($value));
    }

    /** @inheritDoc */
    public function getBalance(): float
    {
        return $this->modelDTO->getBalance();
    }

    /** @inheritDoc */
    public function setBalance(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setBalance($value));
    }

    public function getEmail(): string
    {
        return $this->modelDTO->getEmail();
    }

    /** @inheritDoc */
    public function setEmail(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setEmail($value));
    }

    public function getCityTitle(): string
    {
        return $this->modelDTO->getCityTitle();
    }

    /** @inheritDoc */
    public function setCityTitle(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setCityTitle($value));
    }

    /** @inheritDoc */
    public function getCityId(): ?int
    {
        return $this->modelDTO->getCityId();
    }

    /** @inheritDoc */
    public function setCityId(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setCityId($value));
    }

    /** @inheritDoc */
    public function getDateRegister(): ?DateTime
    {
        return $this->modelDTO->getDateRegister();
    }

    /** @inheritDoc */
    public function setDateRegister(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setDateRegister($value));
    }

    public function getCellPhone(): string
    {
        return $this->modelDTO->getCellPhone();
    }

    /** @inheritDoc */
    public function setCellPhone(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setCellPhone($value));
    }

    public function getZip(): string
    {
        return $this->modelDTO->getZip();
    }

    /** @inheritDoc */
    public function setZip(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setZip($value));
    }

    public function getRegistrationIndex(): string
    {
        return $this->modelDTO->getRegistrationIndex();
    }

    /** @inheritDoc */
    public function setRegistrationIndex(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setRegistrationIndex($value));
    }

    /** @inheritDoc */
    public function getIsVip(): bool
    {
        return $this->modelDTO->getIsVip();
    }

    /** @inheritDoc */
    public function setIsVip(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setIsVip($value));
    }

    public function getLastName(): string
    {
        return $this->modelDTO->getLastName();
    }

    /** @inheritDoc */
    public function setLastName(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setLastName($value));
    }

    public function getFirstName(): string
    {
        return $this->modelDTO->getFirstName();
    }

    /** @inheritDoc */
    public function setFirstName(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setFirstName($value));
    }

    public function getMiddleName(): string
    {
        return $this->modelDTO->getMiddleName();
    }

    /** @inheritDoc */
    public function setMiddleName(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setMiddleName($value));
    }

    public function getStatus(): Status
    {
        return $this->modelDTO->getStatus();
    }

    /** @inheritDoc */
    public function setStatus(Status $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setStatus($value));
    }

    /** @inheritDoc */
    public function getDiscount(): int
    {
        return $this->modelDTO->getDiscount();
    }

    /** @inheritDoc */
    public function setDiscount(int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setDiscount($value));
    }

    public function getPassportSeries(): string
    {
        return $this->modelDTO->getPassportSeries();
    }

    /** @inheritDoc */
    public function setPassportSeries(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setPassportSeries($value));
    }

    public function getLabNumber(): string
    {
        return $this->modelDTO->getLabNumber();
    }

    /** @inheritDoc */
    public function setLabNumber(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setLabNumber($value));
    }

    /** @inheritDoc */
    public function getStreetId(): ?int
    {
        return $this->modelDTO->getStreetId();
    }

    /** @inheritDoc */
    public function setStreetId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setStreetId($value));
    }

    public function getApartment(): string
    {
        return $this->modelDTO->getApartment();
    }

    /** @inheritDoc */
    public function setApartment(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setApartment($value));
    }

    /** @inheritDoc */
    public function getIsUnsubscribed(): bool
    {
        return $this->modelDTO->getIsUnsubscribed();
    }

    /** @inheritDoc */
    public function setUnsubscribe(?bool $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setUnsubscribe($value));
    }

    /** @inheritDoc */
    public function getIsBlacklisted(): bool
    {
        return $this->modelDTO->getIsBlacklisted();
    }

    /** @inheritDoc */
    public function setInBlacklist(?bool $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setInBlacklist($value));
    }

    /** @inheritDoc */
    public function getLastVisitDate(): ?DateTime
    {
        return $this->modelDTO->getLastVisitDate();
    }

    /** @inheritDoc */
    public function setLastVisitDateFromSting(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setLastVisitDateFromSting($value));
    }

    /** @inheritDoc */
    public function setLastVisitDateFromDateTime(DateTime $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setLastVisitDateFromDateTime($value));
    }

    public function getNumberOfJournal(): string
    {
        return $this->modelDTO->getNumberOfJournal();
    }

    /** @inheritDoc */
    public function setNumberOfJournal(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setNumberOfJournal($value));
    }

    public function getPhonePrefix(): string
    {
        return $this->modelDTO->getPhonePrefix();
    }

    /** @inheritDoc */
    public function setPhonePrefix(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setPhonePrefix($value));
    }

    abstract function getCity(): ?City;

    /** Вернет пустую строку если ничего */
    abstract function getClientTypeTitle(): string;

    /** @return MedicalCardByClient[]
     * @throws VetmanagerApiGatewayException
     */
    public function getMedicalCards(): array
    {
        return MedicalCardByClient::getByClientId($this->apiGateway, $this->id);
    }

//    /** @return Pet[]
//     * @throws VetmanagerApiGatewayException
//     */
//    public function getPetsAlive(): array
//    {
//        $pets = $this->apiGateway->getWithQueryBuilder(         #TODO Move to facade of Pet
//            ApiModel::Pet,
//            (new Builder())
//                ->where('owner_id', (string)$this->id)
//                ->where('status', Enum\Pet\Status::Alive->value)
//        );
//
//        return Pet::fromMultipleDtosArrays($this->apiGateway, $pets);     #TODO
//    }

    /** @throws VetmanagerApiGatewayException */
    public function getStreet(): ?Street
    {
        return $this->streetId ? Street::getById($this->apiGateway, $this->streetId) : null;
    }

    public function getFullName(): FullName
    {
        return new FullName($this->getFirstName(), $this->getMiddleName(), $this->getLastName());
    }
}
