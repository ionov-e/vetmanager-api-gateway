<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Admission;

use DateInterval;
use DateTime;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Hydrator\ApiBool;
use VetmanagerApiGateway\Hydrator\ApiDateInterval;
use VetmanagerApiGateway\Hydrator\ApiDateTime;
use VetmanagerApiGateway\Hydrator\ApiFloat;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;

class AdmissionOnlyDto extends AbstractDTO implements AdmissionOnlyDtoInterface
{
    /**
     * @param string|null $admission_date Пример "2020-12-31 17:51:18". Может быть: "0000-00-00 00:00:00" - перевожу в null
     * @param string|null $admission_length Примеры: "00:15:00", "00:00:00" (последнее перевожу в null)
     * @param string|null $create_date Приходит: "2015-07-08 06:43:44", но бывает и "0000-00-00 00:00:00". Последнее переводится в null
     * @param string|null $escorter_id Кроме "0" другие значения искал - не нашел. Думаю передумали реализовывать
     * @param string|null $invoices_sum Default: 0.0000000000
     */
    public function __construct(
        protected ?string $id,
        protected ?string $admission_date,
        protected ?string $description,
        protected ?string $client_id,
        protected ?string $patient_id,
        protected ?string $user_id,
        protected ?string $type_id,
        protected ?string $admission_length,
        protected ?string $status,
        protected ?string $clinic_id,
        protected ?string $direct_direction,
        protected ?string $creator_id,
        protected ?string $create_date,
        protected ?string $escorter_id,
        protected ?string $reception_write_channel,
        protected ?string $is_auto_create,
        protected ?string $invoices_sum,
    )
    {
    }

    public function getId(): int
    {
        return ApiInt::fromStringOrNull($this->id)->getPositiveInt();
    }

    public function getAdmissionDate(): DateTime
    {
        return ApiDateTime::fromFullDateTimeString($this->admission_date)->getDateTimeOrThrow();
    }

    public function getDescription(): string
    {
        return ApiString::fromStringOrNull($this->description)->getStringEvenIfNullGiven();
    }

    public function getClientId(): ?int
    {
        return ApiInt::fromStringOrNull($this->client_id)->getPositiveIntOrNull();
    }

    public function getPetId(): ?int
    {
        return ApiInt::fromStringOrNull($this->patient_id)->getPositiveIntOrNull();
    }

    public function getUserId(): ?int
    {
        return ApiInt::fromStringOrNull($this->user_id)->getPositiveIntOrNull();
    }

    public function getTypeId(): ?int
    {
        return ApiInt::fromStringOrNull($this->type_id)->getPositiveIntOrNull();
    }

    public function getAdmissionLength(): ?DateInterval
    {
        return ApiDateInterval::fromStringHMS($this->admission_length)->getDateIntervalOrNull();
    }

    public function getStatus(): ?StatusEnum
    {
        return $this->status ? StatusEnum::from($this->status) : null;
    }

    public function getClinicId(): ?int
    {
        return ApiInt::fromStringOrNull($this->clinic_id)->getPositiveIntOrNull();
    }

    public function getIsDirectDirection(): bool
    {
        return ApiBool::fromStringOrNull($this->direct_direction)->getBoolOrThrowIfNull();
    }

    public function getCreatorId(): ?int
    {
        return ApiInt::fromStringOrNull($this->creator_id)->getPositiveIntOrNull();
    }

    public function getCreateDate(): DateTime
    {
        return ApiDateTime::fromFullDateTimeString($this->create_date)->getDateTimeOrThrow();
    }

    public function getEscortId(): ?int
    {
        return ApiInt::fromStringOrNull($this->escorter_id)->getPositiveIntOrNull();
    }

    public function getReceptionWriteChannel(): string
    {
        return $this->reception_write_channel;
    }

    public function getIsAutoCreate(): bool
    {
        return ApiBool::fromStringOrNull($this->is_auto_create)->getBoolOrThrowIfNull();
    }

    public function getInvoicesSum(): ?float
    {
        return ApiFloat::fromStringOrNull($this->invoices_sum)->getNonZeroFloatOrNull();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setId(int $value): static
    {
        return self::setPropertyFluently($this, 'id', (string)$value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setAdmissionDateAsString(string $value): static
    {
        return self::setPropertyFluently($this, 'admission_date', $value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setAdmissionDateAsDateTime(DateTime $value): static
    {
        return self::setPropertyFluently($this, 'admission_date', $value->format('Y-m-d H:i:s'));
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDescription(string $value): static
    {
        return self::setPropertyFluently($this, 'description', $value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setClientId(int $value): static
    {
        return self::setPropertyFluently($this, 'client_id', (string)$value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setPatientId(int $value): static
    {
        return self::setPropertyFluently($this, 'patient_id', (string)$value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setUserId(int $value): static
    {
        return self::setPropertyFluently($this, 'user_id', (string)$value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTypeId(int $value): static
    {
        return self::setPropertyFluently($this, 'type_id', (string)$value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setAdmissionLengthAsString(string $value): static
    {
        return self::setPropertyFluently($this, 'admission_length', $value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setAdmissionLengthAsDateInterval(DateInterval $value): static
    {
        return self::setPropertyFluently($this, 'admission_length', $value->format('H:i:s'));
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setStatus(string $value): static
    {
        return self::setPropertyFluently($this, 'status', $value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setClinicId(int $value): static
    {
        return self::setPropertyFluently($this, 'clinic_id', (string)$value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setIsDirectDirection(bool $value): static
    {
        return self::setPropertyFluently($this, 'direct_direction', $value ? "1" : "0");
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCreatorId(int $value): static
    {
        return self::setPropertyFluently($this, 'creator_id', (string)$value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCreateDateAsString(string $value): static
    {
        return self::setPropertyFluently($this, 'create_date', $value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCreateDateAsDateTime(DateTime $value): static
    {
        return self::setPropertyFluently($this, 'create_date', $value->format('Y-m-d H:i:s'));
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setEscortId(int $value): static
    {
        return self::setPropertyFluently($this, 'escorter_id', (string)$value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setReceptionWriteChannel(string $value): static
    {
        return self::setPropertyFluently($this, 'reception_write_channel', $value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setIsAutoCreate(bool $value): static
    {
        return self::setPropertyFluently($this, 'is_auto_create', $value ? "1" : "0");
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setInvoicesSum(?float $value): static
    {
        return self::setPropertyFluently($this, 'invoices_sum', is_null($value) ? null : (string)$value);
    }

    /** @param array{
     *          id: numeric-string,
     *          admission_date: string,
     *          description: string,
     *          client_id: numeric-string,
     *          patient_id: numeric-string,
     *          user_id: numeric-string,
     *          type_id: numeric-string,
     *          admission_length: string,
     *          status: ?string,
     *          clinic_id: numeric-string,
     *          direct_direction: string,
     *          creator_id: numeric-string,
     *          create_date: string,
     *          escorter_id: ?numeric-string,
     *          reception_write_channel: ?string,
     *          is_auto_create: string,
     *          invoices_sum: string,
     *          client: array,
     *          pet?: array,
     *          wait_time?: string,
     *          invoices?: array,
     *          doctor_data?: array,
     *          admission_type_data?: array
     *     } $originalDataArray
     */
}