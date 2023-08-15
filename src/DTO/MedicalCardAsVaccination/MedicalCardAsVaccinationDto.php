<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\MedicalCardAsVaccination;

use DateTime;
use VetmanagerApiGateway\ApiDataInterpreter\ToDateTime;
use VetmanagerApiGateway\ApiDataInterpreter\ToFloat;
use VetmanagerApiGateway\ApiDataInterpreter\ToInt;
use VetmanagerApiGateway\ApiDataInterpreter\ToString;
use VetmanagerApiGateway\DTO\AbstractDTO;

final class MedicalCardAsVaccinationDto extends AbstractDTO implements MedicalCardAsVaccinationDtoInterface
{
    /**
     * @param string|null $id
     * @param string|null $name
     * @param string|null $pet_id
     * @param string|null $date
     * @param string|null $date_nexttime
     * @param string|null $vaccine_id
     * @param string|null $birthday
     * @param string|null $birthday_at_time
     * @param string|null $medcard_id
     * @param string|null $doza_type_id
     * @param string|null $doza_value
     * @param string|null $sale_param_id
     * @param string|null $vaccine_type
     * @param string|null $vaccine_description
     * @param string|null $vaccine_type_title
     * @param string|null $next_admission_id
     * @param string|null $next_visit_time
     * @param string|null $pet_age_at_time_vaccination
     */
    public function __construct(
        protected ?string $id,
        protected ?string $name,
        protected ?string $pet_id,
        protected ?string $date,
        protected ?string $date_nexttime,
        protected ?string $vaccine_id,
        protected ?string $birthday,
        protected ?string $birthday_at_time,
        protected ?string $medcard_id,
        protected ?string $doza_type_id,
        protected ?string $doza_value,
        protected ?string $sale_param_id,
        protected ?string $vaccine_type,
        protected ?string $vaccine_description,
        protected ?string $vaccine_type_title,
        protected ?string $next_admission_id,
        protected ?string $next_visit_time,
        protected ?string $pet_age_at_time_vaccination
    )
    {
    }

    public function getId(): int
    {
        return ToInt::fromStringOrNull($this->id)->getPositiveIntOrThrow();
    }

    public function getName(): string
    {
        return ToString::fromStringOrNull($this->name)->getStringEvenIfNullGiven();
    }

    public function getPetId(): int
    {
        return ToInt::fromStringOrNull($this->pet_id)->getPositiveIntOrThrow();
    }

    public function getDateAsString(): ?string
    {
        return $this->date;
    }

    public function getDateAsDateTime(): ?DateTime
    {
        return ToDateTime::fromFullDateTimeString($this->date)->getDateTimeOrNull();
    }

    public function getDateNextDateTimeAsString(): ?string
    {
        return $this->date_nexttime;
    }

    public function getDateNextDateTimeAsDateTime(): ?DateTime
    {
        return ToDateTime::fromOnlyDateString($this->date_nexttime)->getDateTimeOrNull();
    }

    public function getGoodId(): ?int
    {
        return ToInt::fromStringOrNull($this->vaccine_id)->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function getBirthdayAsString(): ?string
    {
        return $this->birthday;
    }

    public function getBirthdayAsDateTime(): ?DateTime
    {
        return ToDateTime::fromOnlyDateString($this->birthday)->getDateTimeOrNull();
    }

    public function getBirthdayAtTimeAsString(): ?string
    {
        return $this->birthday_at_time;
    }

    public function getMedicalCardId(): int
    {
        return ToInt::fromStringOrNull($this->medcard_id)->getPositiveIntOrThrow();
    }

    public function getDoseTypeId(): int
    {
        return ToInt::fromStringOrNull($this->doza_type_id)->getPositiveIntOrThrow();
    }

    public function getDoseValue(): ?float
    {
        return ToFloat::fromStringOrNull($this->doza_value)->getNonZeroFloatOrNull();
    }

    public function getSaleParamId(): int
    {
        return ToInt::fromStringOrNull($this->sale_param_id)->getPositiveIntOrThrow();
    }

    public function getVaccineTypeId(): ?int
    {
        return ToInt::fromStringOrNull($this->vaccine_type)->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function getVaccineDescription(): ?string
    {
        return ToString::fromStringOrNull($this->vaccine_description)->getStringEvenIfNullGiven();
    }

    public function getVaccineTypeTitle(): string
    {
        return ToString::fromStringOrNull($this->vaccine_type_title)->getStringEvenIfNullGiven();
    }

    public function getNextAdmissionId(): ?int
    {
        return ToInt::fromStringOrNull($this->next_admission_id)->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function getNextVisitTimeAsString(): ?string
    {
        return $this->next_visit_time;
    }

    public function getPetAgeAtTimeVaccinationAsString(): ?string
    {
        return $this->pet_age_at_time_vaccination;
    }

    public function setName(?string $value): static
    {
        return self::setPropertyFluently($this, 'name', $value);
    }

    public function setPetId(?int $value): static
    {
        return self::setPropertyFluently($this, 'pet_id', is_null($value) ? null : (string)$value);
    }

    public function setDateFromString(?string $value): static
    {
        return self::setPropertyFluently($this, 'date', $value);
    }

    public function setDateFromDateTime(DateTime $value): static
    {
        return self::setPropertyFluently($this, 'date', $value->format('Y-m-d H:i:s'));
    }

    public function setDateNextDateTimeFromString(?string $value): static
    {
        return self::setPropertyFluently($this, 'date_nexttime', $value);
    }

    public function setGoodId(?int $value): static
    {
        return self::setPropertyFluently($this, 'vaccine_id', is_null($value) ? null : (string)$value);
    }

    public function setBirthdayFromString(?string $value): static
    {
        return self::setPropertyFluently($this, 'birthday', $value);
    }

    public function setBirthdayFromDateTime(DateTime $value): static
    {
        return self::setPropertyFluently($this, 'birthday', $value->format('Y-m-d'));
    }

    public function setMedicalCardId(?int $value): static
    {
        return self::setPropertyFluently($this, 'medcard_id', is_null($value) ? null : (string)$value);
    }

    public function setDoseTypeId(?int $value): static
    {
        return self::setPropertyFluently($this, 'doza_type_id', is_null($value) ? null : (string)$value);
    }

    public function setDoseValue(?float $value): static
    {
        return self::setPropertyFluently($this, 'doza_value', is_null($value) ? null : (string)$value);
    }

    public function setSaleParamId(?int $value): static
    {
        return self::setPropertyFluently($this, 'sale_param_id', is_null($value) ? null : (string)$value);
    }

    public function setVaccineTypeId(?int $value): static
    {
        return self::setPropertyFluently($this, 'vaccine_type', is_null($value) ? null : (string)$value);
    }

    public function setVaccineDescription(?string $value): static
    {
        return self::setPropertyFluently($this, 'vaccine_description', $value);
    }

    public function setVaccineTypeTitle(?string $value): static
    {
        return self::setPropertyFluently($this, 'vaccine_type_title', $value);
    }

    public function setNextAdmissionId(?int $value): static
    {
        return self::setPropertyFluently($this, 'next_admission_id', is_null($value) ? null : (string)$value);
    }

    public function setNextVisitTimeFromString(?string $value): static
    {
        return self::setPropertyFluently($this, 'next_visit_time', $value);
    }

//    /** @param array{
//     *     id: numeric-string,
//     *     name: string,
//     *     pet_id: numeric-string,
//     *     date: string,
//     *     date_nexttime: string,
//     *     vaccine_id: numeric-string,
//     *     birthday: ?string,
//     *     birthday_at_time: string,
//     *     medcard_id: numeric-string,
//     *     doza_type_id: numeric-string,
//     *     doza_value: string,
//     *     sale_param_id: numeric-string,
//     *     vaccine_type: string,
//     *     vaccine_description: string,
//     *     vaccine_type_title: string,
//     *     next_admission_id: numeric-string,
//     *     next_visit_time: string,
//     *     pet_age_at_time_vaccination: string
//     * } $originalDataArray
//     */
}
