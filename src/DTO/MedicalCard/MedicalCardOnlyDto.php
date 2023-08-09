<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\MedicalCard;

use DateTime;
use VetmanagerApiGateway\ApiDataInterpreter\ToDateTime;
use VetmanagerApiGateway\ApiDataInterpreter\ToFloat;
use VetmanagerApiGateway\ApiDataInterpreter\ToInt;
use VetmanagerApiGateway\ApiDataInterpreter\ToString;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;

class MedicalCardOnlyDto extends AbstractDTO implements MedicalCardOnlyDtoInterface
{
    /**
     * @param string|null $id
     * @param string|null $patient_id
     * @param string|null $date_create
     * @param string|null $date_edit
     * @param string|null $diagnos
     * @param string|null $recomendation
     * @param string|null $invoice
     * @param string|null $admission_type
     * @param string|null $weight
     * @param string|null $temperature
     * @param string|null $meet_result_id
     * @param string|null $description
     * @param string|null $next_meet_id
     * @param string|null $doctor_id
     * @param string|null $creator_id
     * @param string|null $status
     * @param string|null $calling_id
     * @param string|null $admission_id
     * @param string|null $diagnos_text
     * @param string|null $diagnos_type_text
     * @param string|null $clinic_id
     */
    public function __construct(
        protected ?string $id,
        protected ?string $patient_id,
        protected ?string $date_create,
        protected ?string $date_edit,
        protected ?string $diagnos,
        protected ?string $recomendation,
        protected ?string $invoice,
        protected ?string $admission_type,
        protected ?string $weight,
        protected ?string $temperature,
        protected ?string $meet_result_id,
        protected ?string $description,
        protected ?string $next_meet_id,
        protected ?string $doctor_id,
        protected ?string $creator_id,
        protected ?string $status,
        protected ?string $calling_id,
        protected ?string $admission_id,
        protected ?string $diagnos_text,
        protected ?string $diagnos_type_text,
        protected ?string $clinic_id
    )
    {
    }

    public function getId(): int
    {
        return ToInt::fromStringOrNull($this->id)->getPositiveIntOrThrow();
    }

    public function getPetId(): int
    {
        return ToInt::fromStringOrNull($this->patient_id)->getPositiveIntOrThrow();
    }

    public function getDateCreateAsString(): string
    {
        return ToString::fromStringOrNull($this->date_create)->getStringOrThrowIfNull();
    }

    public function getDateCreateAsDateTime(): DateTime
    {
        return ToDateTime::fromOnlyDateString($this->date_create)->getDateTimeOrThrow();
    }

    public function getDateEditAsString(): string
    {
        return ToString::fromStringOrNull($this->date_edit)->getStringOrThrowIfNull();
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

    public function getRecommendation(): string
    {
        return ToString::fromStringOrNull($this->recomendation)->getStringEvenIfNullGiven();
    }

    public function getInvoiceId(): ?int
    {
        return ToInt::fromStringOrNull($this->invoice)->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function getAdmissionTypeId(): ?int
    {
        return ToInt::fromStringOrNull($this->admission_type)->getPositiveIntOrNullOrThrowIfNegative();
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

    public function getDescription(): string
    {
        return ToString::fromStringOrNull($this->description)->getStringEvenIfNullGiven();
    }

    public function getNextMeetId(): ?int
    {
        return ToInt::fromStringOrNull($this->next_meet_id)->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function getUserId(): ?int
    {
        return ToInt::fromStringOrNull($this->doctor_id)->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function getCreatorId(): ?int
    {
        return ToInt::fromStringOrNull($this->creator_id)->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function getStatusAsString(): string
    {
        return $this->status;
    }

    public function getStatusAsEnum(): StatusEnum
    {
        return StatusEnum::from($this->status);
    }

    public function getCallingId(): ?int
    {
        return ToInt::fromStringOrNull($this->calling_id)->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function getAdmissionId(): ?int
    {
        return ToInt::fromStringOrNull($this->admission_id)->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function getDiagnoseText(): string
    {
        return ToString::fromStringOrNull($this->diagnos_text)->getStringEvenIfNullGiven();
    }

    public function getDiagnoseTypeText(): string
    {
        return ToString::fromStringOrNull($this->diagnos_type_text)->getStringEvenIfNullGiven();
    }

    public function getClinicId(): ?int
    {
        return ToInt::fromStringOrNull($this->clinic_id)->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function setPetId(int $value): static
    {
        return self::setPropertyFluently($this, 'patient_id', (string)$value);
    }

    public function setDateCreateFromString(string $value): static
    {
        return self::setPropertyFluently($this, 'date_create', $value);
    }

    public function setDateCreateFromDateTime(DateTime $value): static
    {
        return self::setPropertyFluently($this, 'date_create', $value->format('Y-m-d H:i:s'));
    }

    public function setDateEditFromString(string $value): static
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

    public function setRecommendation(?string $value): static
    {
        return self::setPropertyFluently($this, 'recomendation', $value);
    }

    public function setInvoiceId(?int $value): static
    {
        return self::setPropertyFluently($this, 'invoice', is_null($value) ? null : (string)$value);
    }

    public function setAdmissionTypeId(?int $value): static
    {
        return self::setPropertyFluently($this, 'admission_type', is_null($value) ? null : (string)$value);
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

    public function setDescription(?string $value): static
    {
        return self::setPropertyFluently($this, 'description', $value);
    }

    public function setNextMeetId(?int $value): static
    {
        return self::setPropertyFluently($this, 'next_meet_id', is_null($value) ? null : (string)$value);
    }

    public function setUserId(?int $value): static
    {
        return self::setPropertyFluently($this, 'doctor_id', is_null($value) ? null : (string)$value);
    }

    public function setCreatorId(?int $value): static
    {
        return self::setPropertyFluently($this, 'creator_id', is_null($value) ? null : (string)$value);
    }

    public function setStatusFromString(?string $value): static
    {
        return self::setPropertyFluently($this, 'status', $value);
    }

    public function setStatusFromEnum(StatusEnum $value): static
    {
        return self::setPropertyFluently($this, 'status', $value->value);
    }

    public function setCallingId(?int $value): static
    {
        return self::setPropertyFluently($this, 'calling_id', is_null($value) ? null : (string)$value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setAdmissionId(?int $value): static
    {
        return self::setPropertyFluently($this, 'admission_id', is_null($value) ? null : (string)$value);
    }

    public function setDiagnoseText(?string $value): static
    {
        return self::setPropertyFluently($this, 'diagnos_text', $value);
    }

    public function setDiagnoseTypeText(?string $value): static
    {
        return self::setPropertyFluently($this, 'diagnos_type_text', $value);
    }

    public function setClinicId(?int $value): static
    {
        return self::setPropertyFluently($this, 'clinic_id', is_null($value) ? null : (string)$value);
    }

//    /** @param array{
//     *     id: numeric-string,
//     *     patient_id: numeric-string,
//     *     date_create: string,
//     *     date_edit: ?string,
//     *     diagnos: string,
//     *     recomendation: string,
//     *     invoice: ?string,
//     *     admission_type: ?string,
//     *     weight: ?string,
//     *     temperature: ?string,
//     *     meet_result_id: numeric-string,
//     *     description: string,
//     *     next_meet_id: numeric-string,
//     *     doctor_id: numeric-string,
//     *     creator_id: numeric-string,
//     *     status: string,
//     *     calling_id: numeric-string,
//     *     admission_id: numeric-string,
//     *     diagnos_text: ?string,
//     *     diagnos_type_text: ?string,
//     *     clinic_id: numeric-string,
//     *     patient?: array
//     *    } $originalDataArray
//     */

}
