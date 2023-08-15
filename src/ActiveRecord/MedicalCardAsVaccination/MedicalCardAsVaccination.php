<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\MedicalCardAsVaccination;

use DateInterval;
use DateTime;
use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecord\Admission\AdmissionPlusClientAndPetAndInvoicesAndTypeAndUser;
use VetmanagerApiGateway\ActiveRecord\CreatableInterface;
use VetmanagerApiGateway\ActiveRecord\DeletableInterface;
use VetmanagerApiGateway\ActiveRecord\MedicalCard\MedicalCardPlusPet;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\ApiDataInterpreter\ToDateTime;
use VetmanagerApiGateway\DTO\MedicalCardAsVaccination\MedicalCardAsVaccinationDto;
use VetmanagerApiGateway\DTO\MedicalCardAsVaccination\MedicalCardAsVaccinationDtoInterface;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;
use VetmanagerApiGateway\Facade;

///**
// * @property-read MedicalCardAsVaccinationDto $originalDto
// * @property positive-int $id id из таблицы vaccine_pets
// * @property string $name title из таблицы vaccine_pets
// * @property positive-int $petId
// * @property ?DateTime $date  Дата без времени. Пример: "2012-09-02 00:00:00", а может прийти, если ничего: "0000-00-00". Из таблицы vaccine_pets
// * @property ?DateTime $nextDateTime Может содержать в себе:1) Лишь дату. Тогда в {@see $isTimePresentInNextDateTime} будет false; 2) Дату со временем. Тогда в {@see $isTimePresentInNextDateTime} будет true$ 3) Null; Значение берется из admission_date из таблицы admission ON admission.id = vaccine_pets.next_admission_id.
// * @property bool $isTimePresentInNextDateTime Указывает есть ли время в {@see $nextDateTime}
// * @property positive-int $goodId Default in DB: "0". Но не видел нигде 0 - не предусматриваю
// * @property ?DateTime $petBirthday Дата без времени. Пример: "2012-09-02 00:00:00". Может быть и null
// * @property positive-int $medicalCardId Default: "0". Но не видел нигде 0 - не предусматриваю
// * @property positive-int $doseTypeId Default in DB: "0". Но не видел нигде 0 - не предусматриваю
// * @property float $doseValueDefault: "1.0000000000". Из таблицы vaccine_pets
// * @property positive-int $saleParamId Из таблицы vaccine_pets. Но не видел нигде 0 - не предусматриваю
// * @property ?positive-int $vaccineType
// * @property string $vaccineDescription Default: "". Из таблицы vaccine_pets
// * @property string $vaccineTypeTitle Default: "". Title из таблицы combo_manual_items (строка, где: value = {@see $vaccineType} & combo_manual_id = $comboManualIdOfVaccinationType
// * @property ?positive-int $nextAdmissionId Default in DB: "0". Перевожу в null. Из таблицы vaccine_pets
// * @property-read array{
// *     id: numeric-string,
// *     name: string,
// *     pet_id: numeric-string,
// *     date: string,
// *     date_nexttime: string,
// *     vaccine_id: numeric-string,
// *     birthday: ?string,
// *     birthday_at_time: string,
// *     medcard_id: numeric-string,
// *     doza_type_id: numeric-string,
// *     doza_value: string,
// *     sale_param_id: numeric-string,
// *     vaccine_type: string,
// *     vaccine_description: string,
// *     vaccine_type_title: string,
// *     next_admission_id: numeric-string,
// *     next_visit_time: string,
// *     pet_age_at_time_vaccination: string
// * } $originalDataArray
// * @property-read AbstractMedicalCard medicalCard
// * @property-read ?AdmissionOnly nextAdmission
// * @property-read ?DateInterval petAgeAtVaccinationMoment
// * @property-read ?DateInterval currentPetAgeIfStillAlive
// */
final class MedicalCardAsVaccination extends AbstractActiveRecord implements MedicalCardAsVaccinationDtoInterface, CreatableInterface, DeletableInterface
{
    public static function getDtoClass(): string
    {
        return MedicalCardAsVaccinationDto::class;
    }

    public static function getRouteKey(): string
    {
        return 'medicalcards';
    }

    public static function getModelKeyInResponse(): string
    {
        return 'medicalCards/Vaccinations';
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, MedicalCardAsVaccinationDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    /** @throws VetmanagerApiGatewayException */
    public function create(): self
    {
        return (new Facade\MedicalCardAsVaccination($this->activeRecordFactory))->createNewUsingArray($this->getAsArrayWithSetPropertiesOnly());
    }

    /** @throws VetmanagerApiGatewayException */
    public function update(): self
    {
        return (new Facade\MedicalCardAsVaccination($this->activeRecordFactory))->updateUsingIdAndArray($this->getId(), $this->getAsArrayWithSetPropertiesOnly());
    }

    /** @throws VetmanagerApiGatewayException */
    public function delete(): void
    {
        (new Facade\MedicalCardAsVaccination($this->activeRecordFactory))->delete($this->getId());
    }

    /** @inheritDoc */
    public function getId(): int
    {
        return $this->modelDTO->getId();
    }

    public function getName(): string
    {
        return $this->modelDTO->getName();
    }

    /** @inheritDoc */
    public function getPetId(): int
    {
        return $this->modelDTO->getPetId();
    }

    public function getDateAsString(): ?string
    {
        return $this->modelDTO->getDateAsString();
    }

    /** @inheritDoc */
    public function getDateAsDateTime(): ?DateTime
    {
        return $this->modelDTO->getDateAsDateTime();
    }

    public function getDateNextDateTimeAsString(): ?string
    {
        return $this->modelDTO->getDateNextDateTimeAsString();
    }

    /** @inheritDoc
     * Можно проверить в {@see self::getIsTimePresentInNextDateTime()} присутствует ли время
     */
    public function getDateNextDateTimeAsDateTime(): ?DateTime
    {
        return $this->modelDTO->getDateNextDateTimeAsDateTime();
    }

    /** @inheritDoc */
    public function getGoodId(): ?int
    {
        return $this->modelDTO->getGoodId();
    }

    public function getBirthdayAsString(): ?string
    {
        return $this->modelDTO->getBirthdayAsString();
    }

    /** @inheritDoc */
    public function getBirthdayAsDateTime(): ?DateTime
    {
        return $this->modelDTO->getBirthdayAsDateTime();
    }

    /** @inheritDoc */
    public function getBirthdayAtTimeAsString(): ?string
    {
        return $this->modelDTO->getBirthdayAtTimeAsString();
    }

    /** @inheritDoc */
    public function getMedicalCardId(): int
    {
        return $this->modelDTO->getMedicalCardId();
    }

    /** @inheritDoc */
    public function getDoseTypeId(): int
    {
        return $this->modelDTO->getDoseTypeId();
    }

    /** @inheritDoc */
    public function getDoseValue(): ?float
    {
        return $this->modelDTO->getDoseValue();
    }

    /** @inheritDoc */
    public function getSaleParamId(): int
    {
        return $this->modelDTO->getSaleParamId();
    }

    /** @inheritDoc */
    public function getVaccineTypeId(): ?int
    {
        return $this->modelDTO->getVaccineTypeId();
    }

    public function getVaccineDescription(): ?string
    {
        return $this->modelDTO->getVaccineDescription();
    }

    public function getVaccineTypeTitle(): string
    {
        return $this->modelDTO->getVaccineTypeTitle();
    }

    /** @inheritDoc */
    public function getNextAdmissionId(): ?int
    {
        return $this->modelDTO->getNextAdmissionId();
    }

    /** @inheritDoc */
    public function getNextVisitTimeAsString(): ?string
    {
        return $this->modelDTO->getNextVisitTimeAsString();
    }

    /** @inheritDoc */
    public function getPetAgeAtTimeVaccinationAsString(): ?string
    {
        return $this->modelDTO->getPetAgeAtTimeVaccinationAsString();
    }

    /** @inheritDoc */
    public function setName(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setName($value));
    }

    /** @inheritDoc */
    public function setPetId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setPetId($value));
    }

    /** @inheritDoc */
    public function setDateFromString(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setDateFromString($value));
    }

    /** @inheritDoc */
    public function setDateFromDateTime(DateTime $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setDateFromDateTime($value));
    }

    /** @inheritDoc */
    public function setDateNextDateTimeFromString(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setDateNextDateTimeFromString($value));
    }

    /** @inheritDoc */
    public function setGoodId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setGoodId($value));
    }

    /** @inheritDoc */
    public function setBirthdayFromString(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setBirthdayFromString($value));
    }

    /** @inheritDoc */
    public function setBirthdayFromDateTime(DateTime $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setBirthdayFromDateTime($value));
    }

    /** @inheritDoc */
    public function setMedicalCardId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setMedicalCardId($value));
    }

    /** @inheritDoc */
    public function setDoseTypeId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setDoseTypeId($value));
    }

    /** @inheritDoc */
    public function setDoseValue(?float $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setDoseValue($value));
    }

    /** @inheritDoc */
    public function setSaleParamId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setSaleParamId($value));
    }

    /** @inheritDoc */
    public function setVaccineTypeId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setVaccineTypeId($value));
    }

    /** @inheritDoc */
    public function setVaccineDescription(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setVaccineDescription($value));
    }

    /** @inheritDoc */
    public function setVaccineTypeTitle(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setVaccineTypeTitle($value));
    }

    /** @inheritDoc */
    public function setNextAdmissionId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setNextAdmissionId($value));
    }

    /** @inheritDoc */
    public function setNextVisitTimeFromString(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setNextVisitTimeFromString($value));
    }

    /** @throws VetmanagerApiGatewayException */
    public function getMedicalCard(): MedicalCardPlusPet
    {
        return (new Facade\MedicalCard($this->activeRecordFactory))->getById($this->getMedicalCardId());
    }

    /** @throws VetmanagerApiGatewayException */
    public function getNextAdmission(): ?AdmissionPlusClientAndPetAndInvoicesAndTypeAndUser
    {
        return $this->getNextAdmissionId()
            ? (new Facade\Admission($this->activeRecordFactory))->getById($this->getNextAdmissionId())
            : null;
    }

    /** @throws VetmanagerApiGatewayResponseException */
    public function getPetAgeAtVaccinationMoment(): ?DateInterval
    {
        if (is_null($this->getDateAsDateTime()) || is_null($this->getBirthdayAsDateTime())) {
            return null;
        }

        return date_diff($this->getDateAsDateTime(), $this->getBirthdayAsDateTime());
    }

    /** @throws VetmanagerApiGatewayResponseException */
    public function getCurrentPetAgeIfStillAlive(): ?DateInterval
    {
        return $this->getBirthdayAsDateTime() ? date_diff(new DateTime(), $this->getBirthdayAsDateTime()) : null;
    }

    /** Можно проверить в {@see self::getDateNextDateTimeAsDateTime()} присутствует ли время
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getIsTimePresentInNextDateTime(): bool
    {
        return ToDateTime::isTimePresent($this->getDateNextDateTimeAsDateTime());
    }
}
