<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Client;

use DateTime;
use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecord\City\City;
use VetmanagerApiGateway\ActiveRecord\CreatableInterface;
use VetmanagerApiGateway\ActiveRecord\DeletableInterface;
use VetmanagerApiGateway\ActiveRecord\MedicalCardByClient\MedicalCardByClient;
use VetmanagerApiGateway\ActiveRecord\Pet\PetPlusOwnerAndTypeAndBreedAndColor;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DO\FullName;
use VetmanagerApiGateway\DTO\Client\ClientDtoInterface;
use VetmanagerApiGateway\DTO\Client\ClientOnlyDto;
use VetmanagerApiGateway\DTO\Client\StatusEnum;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade;

///**
// * @property-read ClientOnlyDto $originalDto
// * @property positive-int $id
// * @property string $address
// * @property string $homePhone
// * @property string $workPhone
// * @property string $note
// * @property ?positive-int $typeId
// * @property ?positive-int $howFind
// * @property float $balance Default: '0.0000000000'
// * @property string $email Default: ''
// * @property string $cityTitle
// * @property ?positive-int $cityId
// * @property ?DateTime $dateRegister
// * @property string $cellPhone
// * @property string $zip
// * @property string $registrationIndex
// * @property bool $isVip Default: False
// * @property string $lastName
// * @property string $firstName
// * @property string $middleName
// * @property \VetmanagerApiGateway\DTO\Client\StatusEnum $status Default: Active
// * @property int $discount Default: 0
// * @property string $passportSeries
// * @property string $labNumber
// * @property ?int $streetId
// * @property string $apartment Default: ''
// * @property bool $isUnsubscribed Default: False
// * @property bool $isBlacklisted Default: False
// * @property ?DateTime $lastVisitDate В БД бывает дефолтное значение: '0000-00-00 00:00:00' - переводится в null
// * @property string $numberOfJournal Default: ''
// * @property string $phonePrefix
// * @property-read  array{
// *   id: string,
// *   address: string,
// *   home_phone: string,
// *   work_phone: string,
// *   note: string,
// *   type_id: ?string,
// *   how_find: ?string,
// *   balance: string,
// *   email: string,
// *   city: string,
// *   city_id: ?string,
// *   date_register: string,
// *   cell_phone: string,
// *   zip: string,
// *   registration_index: ?string,
// *   vip: string,
// *   last_name: string,
// *   first_name: string,
// *   middle_name: string,
// *   status: string,
// *   discount: string,
// *   passport_series: string,
// *   lab_number: string,
// *   street_id: string,
// *   apartment: string,
// *   unsubscribe: string,
// *   in_blacklist: string,
// *   last_visit_date: string,
// *   number_of_journal: string,
// *   phone_prefix: ?string,
// *   city_data?: array {
// *      id: string,
// *      title: string,
// *      type_id: string
// *      },
// *   client_type_data?: array {
// *      id: string,
// *      title: string
// *      }
// * } $originalDataArray
// * @property-read ?City $city
// * @property-read string $typeTitle
// * @property-read AdmissionOnly[] $admissions
// * @property-read MedicalCardByClient[] $medicalCards
// * @property-read PetOnly[] $petsAlive
// * @property-read ?StreetOnly $street
// * @property-read FullName $fullName
// * */
abstract class AbstractClient extends AbstractActiveRecord implements ClientDtoInterface, CreatableInterface, DeletableInterface
{
    public function __construct(ActiveRecordFactory $activeRecordFactory, ClientOnlyDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    public static function getRouteKey(): string
    {
        return 'client';
    }


    /** @throws VetmanagerApiGatewayException */
    public function create(): self
    {
        return (new Facade\Client($this->activeRecordFactory))->createNewUsingArray($this->getAsArrayWithSetPropertiesOnly());
    }

    /** @throws VetmanagerApiGatewayException */
    public function update(): self
    {
        return (new Facade\Client($this->activeRecordFactory))->updateUsingIdAndArray($this->getId(), $this->getAsArrayWithSetPropertiesOnly());
    }

    /** @throws VetmanagerApiGatewayException */
    public function delete(): void
    {
        (new Facade\Client($this->activeRecordFactory))->delete($this->getId());
    }

    public function getId(): int
    {
        return $this->modelDTO->getId();
    }

    public function getAddress(): string
    {
        return $this->modelDTO->getAddress();
    }

    public function setAddress(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setAddress($value));
    }

    public function getHomePhone(): string
    {
        return $this->modelDTO->getHomePhone();
    }

    public function setHomePhone(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setHomePhone($value));
    }

    public function getWorkPhone(): string
    {
        return $this->modelDTO->getWorkPhone();
    }

    public function setWorkPhone(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setWorkPhone($value));
    }

    public function getNote(): string
    {
        return $this->modelDTO->getNote();
    }

    public function setNote(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setNote($value));
    }

    public function getTypeId(): ?int
    {
        return $this->modelDTO->getTypeId();
    }

    public function setTypeId(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setTypeId($value));
    }

    public function getHowFind(): ?int
    {
        return $this->modelDTO->getHowFind();
    }

    public function setHowFind(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setHowFind($value));
    }

    public function getBalance(): float
    {
        return $this->modelDTO->getBalance();
    }

    public function setBalance(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setBalance($value));
    }

    public function getEmail(): string
    {
        return $this->modelDTO->getEmail();
    }

    public function setEmail(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setEmail($value));
    }

    public function getCityTitle(): string
    {
        return $this->modelDTO->getCityTitle();
    }

    public function setCityTitle(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setCityTitle($value));
    }

    public function getCityId(): ?int
    {
        return $this->modelDTO->getCityId();
    }

    public function setCityId(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setCityId($value));
    }

    public function getDateRegisterAsDateTime(): ?DateTime
    {
        return $this->modelDTO->getDateRegisterAsDateTime();
    }

    public function setDateRegisterFromString(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setDateRegisterFromString($value));
    }


    public function setDateRegisterFromDateTime(DateTime $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setDateRegisterFromDateTime($value));
    }

    public function getCellPhone(): string
    {
        return $this->modelDTO->getCellPhone();
    }

    public function setCellPhone(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setCellPhone($value));
    }

    public function getZip(): string
    {
        return $this->modelDTO->getZip();
    }

    public function setZip(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setZip($value));
    }

    public function getRegistrationIndex(): string
    {
        return $this->modelDTO->getRegistrationIndex();
    }

    public function setRegistrationIndex(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setRegistrationIndex($value));
    }

    public function getIsVip(): bool
    {
        return $this->modelDTO->getIsVip();
    }

    public function setIsVip(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setIsVip($value));
    }

    public function getLastName(): string
    {
        return $this->modelDTO->getLastName();
    }

    public function setLastName(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setLastName($value));
    }

    public function getFirstName(): string
    {
        return $this->modelDTO->getFirstName();
    }

    public function setFirstName(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setFirstName($value));
    }

    public function getMiddleName(): string
    {
        return $this->modelDTO->getMiddleName();
    }

    public function setMiddleName(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setMiddleName($value));
    }

    public function getStatusAsEnum(): StatusEnum
    {
        return $this->modelDTO->getStatusAsEnum();
    }

    public function setStatusAsEnum(StatusEnum $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setStatusAsEnum($value));
    }

    public function getStatusAsString(): ?string
    {
        return $this->modelDTO->getStatusAsString();
    }

    public function setStatusAsString(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setStatusAsString($value));
    }

    public function getDiscount(): int
    {
        return $this->modelDTO->getDiscount();
    }

    public function setDiscount(int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setDiscount($value));
    }

    public function getPassportSeries(): string
    {
        return $this->modelDTO->getPassportSeries();
    }

    public function setPassportSeries(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setPassportSeries($value));
    }

    public function getLabNumber(): string
    {
        return $this->modelDTO->getLabNumber();
    }

    public function setLabNumber(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setLabNumber($value));
    }

    public function getStreetId(): ?int
    {
        return $this->modelDTO->getStreetId();
    }

    public function setStreetId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setStreetId($value));
    }

    public function getApartment(): string
    {
        return $this->modelDTO->getApartment();
    }

    public function setApartment(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setApartment($value));
    }

    public function getIsUnsubscribed(): bool
    {
        return $this->modelDTO->getIsUnsubscribed();
    }

    public function setUnsubscribe(bool $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setUnsubscribe($value));
    }

    public function getIsBlacklisted(): bool
    {
        return $this->modelDTO->getIsBlacklisted();
    }

    public function setInBlacklist(bool $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setInBlacklist($value));
    }

    public function getLastVisitDateAsDateTime(): ?DateTime
    {
        return $this->modelDTO->getLastVisitDateAsDateTime();
    }

    public function setLastVisitDateFromSting(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setLastVisitDateFromSting($value));
    }

    public function setLastVisitDateFromDateTime(DateTime $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setLastVisitDateFromDateTime($value));
    }

    public function getNumberOfJournal(): string
    {
        return $this->modelDTO->getNumberOfJournal();
    }

    public function setNumberOfJournal(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setNumberOfJournal($value));
    }

    public function getPhonePrefix(): string
    {
        return $this->modelDTO->getPhonePrefix();
    }

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
        return (new \VetmanagerApiGateway\Facade\MedicalCardByClient($this->activeRecordFactory))->getByClientId($this->getId());
    }

    /** @return PetPlusOwnerAndTypeAndBreedAndColor[]
     * @throws VetmanagerApiGatewayException
     */
    public function getPetsAlive(): array
    {
        return (new \VetmanagerApiGateway\Facade\Pet($this->activeRecordFactory))->getOnlyAliveByClientId($this->getId());
    }

    /** @throws VetmanagerApiGatewayException */
    public function getStreet(): ?\VetmanagerApiGateway\ActiveRecord\Street\StreetPlusCity
    {
        return $this->getStreetId() ? (new \VetmanagerApiGateway\Facade\Street($this->activeRecordFactory))->getById($this->getStreetId()) : null;
    }

    public function getFullName(): FullName
    {
        return new FullName($this->getFirstName(), $this->getMiddleName(), $this->getLastName());
    }
}
