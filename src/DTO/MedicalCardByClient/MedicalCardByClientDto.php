<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\MedicalCardByClient;

use DateTime;
use VetmanagerApiGateway\ApiDataInterpreter\ToBool;
use VetmanagerApiGateway\ApiDataInterpreter\ToDateTime;
use VetmanagerApiGateway\ApiDataInterpreter\ToFloat;
use VetmanagerApiGateway\ApiDataInterpreter\ToInt;
use VetmanagerApiGateway\ApiDataInterpreter\ToString;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\DTO\Pet\SexEnum;

final class MedicalCardByClientDto extends AbstractDTO implements MedicalCardByClientDtoInterface
{
    /**
     * @param string|null $medical_card_id
     * @param string|null $date_edit
     * @param string|null $diagnos
     * @param string|null $doctor_id
     * @param string|null $medical_card_status
     * @param string|null $healing_process
     * @param string|null $recomendation
     * @param string|null $weight
     * @param string|null $temperature
     * @param string|null $meet_result_id
     * @param string|null $admission_type
     * @param string|null $pet_id
     * @param string|null $alias
     * @param string|null $birthday
     * @param string|null $sex
     * @param string|null $note
     * @param string|null $pet_type
     * @param string|null $breed
     * @param string|null $client_id
     * @param string|null $first_name
     * @param string|null $last_name
     * @param string|null $middle_name
     * @param string|null $phone
     * @param string|null $doctor_nickname
     * @param string|null $doctor_first_name
     * @param string|null $doctor_last_name
     * @param string|null $doctor_middle_name
     * @param string|null $editable
     * @param string|null $meet_result_title
     * @param string|null $admission_type_title
     */
    public function __construct(
        protected ?string $medical_card_id,
        protected ?string $date_edit,
        protected ?string $diagnos,
        protected ?string $doctor_id,
        protected ?string $medical_card_status,
        protected ?string $healing_process,
        protected ?string $recomendation,
        protected ?string $weight,
        protected ?string $temperature,
        protected ?string $meet_result_id,
        protected ?string $admission_type,
        protected ?string $pet_id,
        protected ?string $alias,
        protected ?string $birthday,
        protected ?string $sex,
        protected ?string $note,
        protected ?string $pet_type,
        protected ?string $breed,
        protected ?string $client_id,
        protected ?string $first_name,
        protected ?string $last_name,
        protected ?string $middle_name,
        protected ?string $phone,
        protected ?string $doctor_nickname,
        protected ?string $doctor_first_name,
        protected ?string $doctor_last_name,
        protected ?string $doctor_middle_name,
        protected ?string $editable,
        protected ?string $meet_result_title,
        protected ?string $admission_type_title
    ) {
    }

    public function getId(): int
    {
        return ToInt::fromStringOrNull($this->medical_card_id)->getPositiveIntOrThrow();
    }

    public function getDateEditAsString(): ?string
    {
        return $this->date_edit;
    }

    public function getDateEditAsDateTime(): DateTime
    {
        return ToDateTime::fromOnlyDateString($this->date_edit)->getDateTimeOrThrow();
    }

    public function getDiagnose(): string
    {
        $diagnose = ($this->diagnos !== '0') ? $this->diagnos : '';
        return ToString::fromStringOrNull($diagnose)->getStringEvenIfNullGiven();
    }

    public function getUserId(): ?int
    {
        return ToInt::fromStringOrNull($this->doctor_id)->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function getStatusAsString(): string
    {
        return $this->medical_card_status;
    }

    public function getStatusAsEnum(): \VetmanagerApiGateway\DTO\MedicalCard\StatusEnum
    {
        return \VetmanagerApiGateway\DTO\MedicalCard\StatusEnum::from($this->medical_card_status);
    }

    public function getDescription(): string
    {
        return ToString::fromStringOrNull($this->healing_process)->getStringEvenIfNullGiven();
    }

    public function getRecommendation(): string
    {
        return ToString::fromStringOrNull($this->recomendation)->getStringEvenIfNullGiven();
    }

    public function getWeight(): ?float
    {
        return ToFloat::fromStringOrNull($this->weight)->getNonZeroFloatOrNull();
    }

    public function getTemperature(): ?float
    {
        return ToFloat::fromStringOrNull($this->temperature)->getNonZeroFloatOrNull();
    }

    public function getMeetResultId(): ?int
    {
        return ToInt::fromStringOrNull($this->meet_result_id)->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function getAdmissionTypeId(): ?int
    {
        return ToInt::fromStringOrNull($this->admission_type)->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function getPetId(): int
    {
        return ToInt::fromStringOrNull($this->pet_id)->getPositiveIntOrThrow();
    }

    public function getPetAlias(): string
    {
        return ToString::fromStringOrNull($this->alias)->getStringEvenIfNullGiven();
    }

    public function getBirthdayAsString(): ?string
    {
        return $this->birthday;
    }

    public function getBirthdayAsDateTime(): ?DateTime
    {
        return ToDateTime::fromOnlyDateString($this->birthday)->getDateTimeOrThrow();
    }

    public function getSexAsString(): ?string
    {
        return $this->sex;
    }

    public function getSexAsEnum(): SexEnum
    {
        return $this->sex ? SexEnum::from($this->sex) : SexEnum::Unknown;
    }

    public function getPetNote(): string
    {
        return ToString::fromStringOrNull($this->note)->getStringEvenIfNullGiven();
    }

    public function getPetTypeTitle(): string
    {
        return  ToString::fromStringOrNull($this->pet_type)->getStringEvenIfNullGiven();
    }

    public function getBreedTitle(): string
    {
        return ToString::fromStringOrNull($this->breed)->getStringEvenIfNullGiven();
    }

    public function getClientId(): ?int
    {
        return ToInt::fromStringOrNull($this->client_id)->getPositiveIntOrThrow();
    }

    public function getFirstName(): string
    {
        return ToString::fromStringOrNull($this->first_name)->getStringEvenIfNullGiven();
    }

    public function getLastName(): string
    {
        return ToString::fromStringOrNull($this->last_name)->getStringEvenIfNullGiven();
    }

    public function getMiddleName(): string
    {
        return ToString::fromStringOrNull($this->middle_name)->getStringEvenIfNullGiven();
    }

    public function getOwnerPhone(): string
    {
        return ToString::fromStringOrNull($this->phone)->getStringEvenIfNullGiven();
    }

    public function getUserLogin(): string
    {
        return ToString::fromStringOrNull($this->doctor_nickname)->getStringEvenIfNullGiven();
    }

    public function getUserFirstName(): string
    {
        return ToString::fromStringOrNull($this->doctor_first_name)->getStringEvenIfNullGiven();
    }

    public function getUserLastName(): string
    {
        return ToString::fromStringOrNull($this->doctor_last_name)->getStringEvenIfNullGiven();
    }

    public function getUserMiddleName(): string
    {
        return ToString::fromStringOrNull($this->doctor_middle_name)->getStringEvenIfNullGiven();
    }

    public function getIsEditable(): bool
    {
        return ToBool::fromStringOrNull($this->editable)->getBoolOrThrowIfNull();
    }

    public function getMeetResultTitle(): string
    {
        return ToString::fromStringOrNull($this->meet_result_title)->getStringEvenIfNullGiven();
    }

    public function getAdmissionTypeTitle(): string
    {
        return ToString::fromStringOrNull($this->admission_type_title)->getStringEvenIfNullGiven();
    }

    public function setDateEditFromString(?string $value): static
    {
        return self::setPropertyFluently($this, 'date_edit', $value);
    }

    public function setDateEditFromDateTime(DateTime $value): static
    {
        return self::setPropertyFluently($this, 'date_edit', $value->format('Y-m-d H:i:s'));
    }

    public function setDiagnose(?string $value): static
    {
        return self::setPropertyFluently($this, 'diagnos', $value);
    }

    public function setUserId(?int $value): static
    {
        return self::setPropertyFluently($this, 'doctor_id', (string)$value);
    }

    public function setStatusFromString(?string $value): static
    {
        return self::setPropertyFluently($this, 'medical_card_status', $value);
    }

    public function setStatusFromEnum(\VetmanagerApiGateway\DTO\MedicalCard\StatusEnum $value): static
    {
        return self::setPropertyFluently($this, 'medical_card_status', $value->value);
    }

    public function setDescription(?string $value): static
    {
        return self::setPropertyFluently($this, 'healing_process', $value);
    }

    public function setRecommendation(?string $value): static
    {
        return self::setPropertyFluently($this, 'recomendation', $value);
    }

    public function setWeight(?float $value): static
    {
        return self::setPropertyFluently($this, 'weight', is_null($value) ? null : (string)$value);
    }

    public function setTemperature(?float $value): static
    {
        return self::setPropertyFluently($this, 'temperature', is_null($value) ? null : (string)$value);
    }

    public function setMeetResultId(?int $value): static
    {
        return self::setPropertyFluently($this, 'meet_result_id', is_null($value) ? null : (string)$value);
    }

    public function setAdmissionTypeId(?int $value): static
    {
        return self::setPropertyFluently($this, 'admission_type', is_null($value) ? null : (string)$value);
    }

    public function setPetId(?int $value): static
    {
        return self::setPropertyFluently($this, 'pet_id', is_null($value) ? null : (string)$value);
    }

    public function setPetAlias(?string $value): static
    {
        return self::setPropertyFluently($this, 'alias', $value);
    }

    public function setBirthdayFromString(?string $value): static
    {
        return self::setPropertyFluently($this, 'birthday', $value);
    }

    public function setBirthdayFromDateTime(DateTime $value): static
    {
        return self::setPropertyFluently($this, 'birthday', $value->format('H:i:s'));
    }

    public function setSexFromString(?string $value): static
    {
        return self::setPropertyFluently($this, 'sex', $value);
    }

    public function setSexFromEnum(SexEnum $value): static
    {
        return self::setPropertyFluently($this, 'sex', $value->value);
    }

    public function setPetNote(?string $value): static
    {
        return self::setPropertyFluently($this, 'note', $value);
    }

    public function setPetTypeTitle(?string $value): static
    {
        return self::setPropertyFluently($this, 'pet_type', $value);
    }

    public function setBreedTitle(?string $value): static
    {
        return self::setPropertyFluently($this, 'breed', $value);
    }

    public function setClientId(?int $value): static
    {
        return self::setPropertyFluently($this, 'client_id', is_null($value) ? null : (string)$value);
    }

    public function setFirstName(?string $value): static
    {
        return self::setPropertyFluently($this, 'first_name', $value);
    }

    public function setLastName(?string $value): static
    {
        return self::setPropertyFluently($this, 'last_name', $value);
    }

    public function setMiddleName(?string $value): static
    {
        return self::setPropertyFluently($this, 'middle_name', $value);
    }

    public function setOwnerPhone(?string $value): static
    {
        return self::setPropertyFluently($this, 'phone', $value);
    }

    public function setUserLogin(?string $value): static
    {
        return self::setPropertyFluently($this, 'doctor_nickname', $value);
    }

    public function setUserFirstName(?string $value): static
    {
        return self::setPropertyFluently($this, 'doctor_first_name', $value);
    }

    public function setUserLastName(?string $value): static
    {
        return self::setPropertyFluently($this, 'doctor_last_name', $value);
    }

    public function setUserMiddleName(?string $value): static
    {
        return self::setPropertyFluently($this, 'doctor_middle_name', $value);
    }

    public function setIsEditable(?bool $value): static
    {
        return self::setPropertyFluently($this, 'editable', is_null($value) ? null : (string)(int)$value);
    }

    public function setMeetResultTitle(?string $value): static
    {
        return self::setPropertyFluently($this, 'meet_result_title', $value);
    }

    public function setAdmissionTypeTitle(?string $value): static
    {
        return self::setPropertyFluently($this, 'admission_type_title', $value);
    }

//    /** @param array{
//     *     medical_card_id: numeric-string,
//     *     date_edit: ?string,
//     *     diagnos: string,
//     *     doctor_id: numeric-string,
//     *     medical_card_status: string,
//     *     healing_process: ?string,
//     *     recomendation: string,
//     *     weight: ?string,
//     *     temperature: ?string,
//     *     meet_result_id: numeric-string,
//     *     admission_type: ?string,
//     *     pet_id: numeric-string,
//     *     alias: string,
//     *     birthday: ?string,
//     *     sex: string,
//     *     note: string,
//     *     pet_type: string,
//     *     breed: string,
//     *     client_id: numeric-string,
//     *     first_name: string,
//     *     last_name: string,
//     *     middle_name: string,
//     *     phone: string,
//     *     doctor_nickname: string,
//     *     doctor_first_name: string,
//     *     doctor_last_name: string,
//     *     doctor_middle_name: string,
//     *     editable: string,
//     *     meet_result_title: string,
//     *     admission_type_title: string
//     *    } $originalDataArray
//     */
}
