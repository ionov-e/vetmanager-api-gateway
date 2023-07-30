<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Clinic;

use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;

final class ClinicOnlyDto extends AbstractDTO implements ClinicOnlyDtoInterface
{
    /**
     * @param string|null $id
     * @param string|null $title
     * @param string|null $address
     * @param string|null $phone
     * @param string|null $city_id
     * @param string|null $start_time
     * @param string|null $end_time
     * @param string|null $internet_address
     * @param string|null $guest_client_id
     * @param string|null $time_zone
     * @param string|null $logo_url
     * @param string|null $status
     * @param string|null $telegram
     * @param string|null $whatsapp
     * @param string|null $email
     */
    public function __construct(
        protected ?string $id,
        protected ?string $title,
        protected ?string $address,
        protected ?string $phone,
        protected ?string $city_id,
        protected ?string $start_time,
        protected ?string $end_time,
        protected ?string $internet_address,
        protected ?string $guest_client_id,
        protected ?string $time_zone,
        protected ?string $logo_url,
        protected ?string $status,
        protected ?string $telegram,
        protected ?string $whatsapp,
        protected ?string $email
    ) {
    }

    public function getId(): int
    {
        return ApiInt::fromStringOrNull($this->id)->getPositiveInt();
    }

    public function getTitle(): string
    {
        return ApiString::fromStringOrNull($this->title)->getStringEvenIfNullGiven();
    }

    public function getAddress(): string
    {
        return ApiString::fromStringOrNull($this->address)->getStringEvenIfNullGiven();
    }

    public function getPhone(): string
    {
        return ApiString::fromStringOrNull($this->phone)->getStringEvenIfNullGiven();
    }

    public function getCityId(): ?int
    {
        return ApiInt::fromStringOrNull($this->city_id)->getPositiveIntOrNull();
    }

    public function getStartTime(): string
    {
        return ApiString::fromStringOrNull($this->start_time)->getStringEvenIfNullGiven();
    }

    public function getEndTime(): string
    {
        return ApiString::fromStringOrNull($this->end_time)->getStringEvenIfNullGiven();
    }

    public function getInternetAddress(): string
    {
        return ApiString::fromStringOrNull($this->internet_address)->getStringEvenIfNullGiven();
    }

    public function getGuestClientId(): ?int
    {
        return ApiInt::fromStringOrNull($this->guest_client_id)->getPositiveIntOrNull();
    }

    public function getTimeZone(): string
    {
        return ApiString::fromStringOrNull($this->time_zone)->getStringEvenIfNullGiven();
    }

    public function getLogoUrl(): string
    {
        return ApiString::fromStringOrNull($this->logo_url)->getStringEvenIfNullGiven();
    }

    public function getStatus(): \VetmanagerApiGateway\DTO\Clinic\StatusEnum
    {
        return \VetmanagerApiGateway\DTO\Clinic\StatusEnum::from($this->status);
    }

    public function getTelegram(): string
    {
        return ApiString::fromStringOrNull($this->telegram)->getStringEvenIfNullGiven();
    }

    public function getWhatsapp(): string
    {
        return ApiString::fromStringOrNull($this->whatsapp)->getStringEvenIfNullGiven();
    }

    public function getEmail(): string
    {
        return ApiString::fromStringOrNull($this->email)->getStringEvenIfNullGiven();
    }

    public function setId(int $value): static
    {
        return self::setPropertyFluently($this, 'id', (string)$value);
    }

    public function setTitle(?string $value): static
    {
        return self::setPropertyFluently($this, 'title', $value);
    }

    public function setAddress(?string $value): static
    {
        return self::setPropertyFluently($this, 'address', $value);
    }

    public function setPhone(?string $value): static
    {
        return self::setPropertyFluently($this, 'phone', $value);
    }

    public function setCityId(int $value): static
    {
        return self::setPropertyFluently($this, 'city_id', (string)$value);
    }

    public function setStartTime(?string $value): static
    {
        return self::setPropertyFluently($this, 'start_time', $value);
    }

    public function setEndTime(?string $value): static
    {
        return self::setPropertyFluently($this, 'end_time', $value);
    }

    public function setInternetAddress(?string $value): static
    {
        return self::setPropertyFluently($this, 'internet_address', $value);
    }

    public function setGuestClientId(int $value): static
    {
        return self::setPropertyFluently($this, 'guest_client_id', $value ? (string)$value : null);
    }

    public function setTimeZone(?string $value): static
    {
        return self::setPropertyFluently($this, 'time_zone', $value);
    }

    public function setLogoUrl(?string $value): static
    {
        return self::setPropertyFluently($this, 'logo_url', $value);
    }

    public function setStatusFromEnum(\VetmanagerApiGateway\DTO\Client\StatusEnum $value): static
    {
        return self::setPropertyFluently($this, 'status', $value->value);
    }

    public function setStatusFromString(?string $value): static
    {
        return self::setPropertyFluently($this, 'status', $value);
    }

    public function setTelegram(?string $value): static
    {
        return self::setPropertyFluently($this, 'telegram', $value);
    }

    public function setWhatsapp(?string $value): static
    {
        return self::setPropertyFluently($this, 'whatsapp', $value);
    }

    public function setEmail(?string $value): static
    {
        return self::setPropertyFluently($this, 'email', $value);
    }

    /** @param array{
     *     "id": string,
     *     "title": ?string,
     *     "address": ?string,
     *     "phone": ?string,
     *     "city_id": ?string,
     *     "start_time": ?string,
     *     "end_time": ?string,
     *     "internet_address": ?string,
     *     "guest_client_id": ?string,
     *     "time_zone": ?string,
     *     "logo_url": string,
     *     "status": string,
     *     "telegram": string,
     *     "whatsapp": string,
     *     "email": string
     * } $originalDataArray
     */
}
