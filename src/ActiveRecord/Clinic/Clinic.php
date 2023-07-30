<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Clinic;

use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DO\FullPhone;
use VetmanagerApiGateway\DTO\Clinic\ClinicOnlyDto;
use VetmanagerApiGateway\DTO\Clinic\ClinicOnlyDtoInterface;
use VetmanagerApiGateway\DTO\Clinic\StatusEnum;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade\Property;

/**
 * @property-read ClinicOnlyDto $originalDto
 * @property positive-int $id
 * @property string $title
 * @property string $address
 * @property string $phone
 * @property ?positive-int $cityId
 * @property string $startTime Время вида: "00:00" или пустая строка
 * @property string $endTime Время вида: 23:45 или пустая строка
 * @property string $internetAddress
 * @property ?positive-int $guestClientId
 * @property string $timeZone Пример: "Europe/Kiev"
 * @property string $logoUrl Default: ''
 * @property StatusEnum $status
 * @property string $telegram Default: ''
 * @property string $whatsapp Default: ''
 * @property string $email Default: ''
 * @property-read array{
 *     id: numeric-string,
 *     title: ?string,
 *     address: ?string,
 *     phone: ?string,
 *     city_id: ?numeric-string,
 *     start_time: ?string,
 *     end_time: ?string,
 *     internet_address: ?string,
 *     guest_client_id: ?numeric-string,
 *     time_zone: ?string,
 *     logo_url: string,
 *     status: string,
 *     telegram: string,
 *     whatsapp: string,
 *     email: string
 * } $originalDataArray
 * @property-read FullPhone $fullPhone
 * @property-read bool $isOnlineSigningUpAvailable
 */
final class Clinic extends AbstractActiveRecord implements ClinicOnlyDtoInterface
{
    public static function getDtoClass(): string
    {
        return ClinicOnlyDto::class;
    }

    public static function getRouteKey(): string
    {
        return 'clinics';
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, ClinicOnlyDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    public function getId(): int
    {
        return $this->modelDTO->getId();
    }

    public function getTitle(): string
    {
        return $this->modelDTO->getTitle();
    }

    public function getAddress(): string
    {
        return $this->modelDTO->getAddress();
    }

    public function getPhone(): string
    {
        return $this->modelDTO->getPhone();
    }

    public function getCityId(): ?int
    {
        return $this->modelDTO->getCityId();
    }

    public function getStartTime(): string
    {
        return $this->modelDTO->getStartTime();
    }

    public function getEndTime(): string
    {
        return $this->modelDTO->getEndTime();
    }

    public function getInternetAddress(): string
    {
        return $this->modelDTO->getInternetAddress();
    }

    public function getGuestClientId(): ?int
    {
        return $this->modelDTO->getGuestClientId();
    }

    public function getTimeZone(): string
    {
        return $this->modelDTO->getTimeZone();
    }

    public function getLogoUrl(): string
    {
        return $this->modelDTO->getLogoUrl();
    }

    public function getStatus(): \VetmanagerApiGateway\DTO\Clinic\StatusEnum
    {
        return $this->modelDTO->getStatus();
    }

    public function getTelegram(): string
    {
        return $this->modelDTO->getTelegram();
    }

    public function getWhatsapp(): string
    {
        return $this->modelDTO->getWhatsapp();
    }

    public function getEmail(): string
    {
        return $this->modelDTO->getEmail();
    }

    public function setId(int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setId($value));
    }

    public function setTitle(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setTitle($value));
    }

    public function setAddress(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setAddress($value));
    }

    public function setPhone(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setPhone($value));
    }

    public function setCityId(int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setCityId($value));
    }

    public function setStartTime(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setStartTime($value));
    }

    public function setEndTime(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setEndTime($value));
    }

    public function setInternetAddress(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setInternetAddress($value));
    }

    public function setGuestClientId(int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setGuestClientId($value));
    }

    public function setTimeZone(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setTimeZone($value));
    }

    public function setLogoUrl(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setLogoUrl($value));
    }

    public function setStatusFromEnum(\VetmanagerApiGateway\DTO\Client\StatusEnum $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setStatusFromEnum($value));
    }

    public function setStatusFromString(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setStatusFromString($value));
    }

    public function setTelegram(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setTelegram($value));
    }

    public function setWhatsapp(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setWhatsapp($value));
    }

    public function setEmail(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setEmail($value));
    }

    /** @throws VetmanagerApiGatewayException */
    public function getFullPhone(): FullPhone
    {
        $phonePrefix = (new Property($this->activeRecordFactory))->getValueByClinicIdAndPropertyName($this->id, "unisender_phone_pristavka");
        $phoneMask = (new Property($this->activeRecordFactory))->getValueByClinicIdAndPropertyName($this->id, "phone_mask");
        return (new FullPhone($phonePrefix ?? '', $this->phone, $phoneMask ?? ''));
    }

    /** @throws VetmanagerApiGatewayException */
    public function isOnlineSigningUpAvailable(): bool
    {
        return (new Property($this->activeRecordFactory))->isOnlineSigningUpAvailableForClinic($this->id);
    }
}
