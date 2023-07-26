<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Enum\Completeness;
use VetmanagerApiGateway\ActiveRecord\Interface\AllRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllRequestsTrait;
use VetmanagerApiGateway\DO\FullPhone;
use VetmanagerApiGateway\DTO\ClinicDto;
use VetmanagerApiGateway\DTO\Enum\Clinic\Status;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/**
 * @property-read ClinicDto $originalDto
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
 * @property Status $status
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
final class Clinic extends AbstractActiveRecord implements AllRequestsInterface
{
    use AllRequestsTrait;

    public static function getApiModel(): ApiModel
    {
        return ApiModel::Clinic;
    }

    public static function getCompletenessFromGetAllOrByQuery(): Completeness
    {
        return Completeness::Full;
    }

    /**
     * @throws VetmanagerApiGatewayException
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'fullPhone' => $this->getFullPhone(),
            'isOnlineSigningUpAvailable' => Property::isOnlineSigningUpAvailableForClinic($this->activeRecordFactory, $this->id),
            default => $this->originalDto->$name
        };
    }

    /** @throws VetmanagerApiGatewayException */
    private function getFullPhone(): FullPhone
    {
        $phonePrefix = Property::getValueByClinicIdAndPropertyName($this->activeRecordFactory, $this->id, "unisender_phone_pristavka");
        $phoneMask = Property::getValueByClinicIdAndPropertyName($this->activeRecordFactory, $this->id, "phone_mask");
        return (new FullPhone($phonePrefix ?? '', $this->phone, $phoneMask ?? ''));
    }
}
