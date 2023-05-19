<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\FullPhone;
use VetmanagerApiGateway\DTO\Enum\Clinic\Status;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;

/** @property-read FullPhone fullPhone
 * @property-read bool isOnlineSigningUpAvailable
 */
final class Clinic extends AbstractActiveRecord implements AllGetRequestsInterface
{

    use AllGetRequestsTrait;

    /** @var positive-int */
    public int $id;
    public string $title;
    public string $address;
    public string $phone;
    /** @var positive-int|null */
    public ?int $cityId;
    /** Время вида: "00:00" или пустая строка */
    public string $startTime;
    /** Время вида: 23:45 или пустая строка */
    public string $endTime;
    public string $internetAddress;
    /** @var positive-int|null Default: '0' - переводим в null */
    public ?int $guestClientId;
    /** Пример: "Europe/Kiev" */
    public string $timeZone;
    /** Default: '' */
    public string $logoUrl;
    public Status $status;
    /** Default: '' */
    public string $telegram;
    /** Default: '' */
    public string $whatsapp;
    /** Default: '' */
    public string $email;

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
     * } $originalData
     * @throws VetmanagerApiGatewayException
     */
    public function __construct(ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = ApiInt::fromStringOrNull($originalData['id'])->positiveInt;
        $this->title = ApiString::fromStringOrNull($originalData['title'])->string;
        $this->address = ApiString::fromStringOrNull($originalData['address'])->string;
        $this->phone = ApiString::fromStringOrNull($originalData['phone'])->string;
        $this->cityId = ApiInt::fromStringOrNull($originalData['city_id'])->positiveIntOrNull;
        $this->startTime = ApiString::fromStringOrNull($originalData['start_time'])->string;
        $this->endTime = ApiString::fromStringOrNull($originalData['end_time'])->string;
        $this->internetAddress = ApiString::fromStringOrNull($originalData['internet_address'])->string;
        $this->guestClientId = ApiInt::fromStringOrNull($originalData['guest_client_id'])->positiveIntOrNull;
        $this->timeZone = ApiString::fromStringOrNull($originalData['time_zone'])->string;
        $this->logoUrl = ApiString::fromStringOrNull($originalData['logo_url'])->string;
        $this->status = Status::from($originalData['status']);
        $this->telegram = ApiString::fromStringOrNull($originalData['telegram'])->string;
        $this->whatsapp = ApiString::fromStringOrNull($originalData['whatsapp'])->string;
        $this->email = ApiString::fromStringOrNull($originalData['email'])->string;
    }

    /** @return ApiModel::Clinic */
    public static function getApiModel(): ApiModel
    {
        return ApiModel::Clinic;
    }

    /**
     * @throws VetmanagerApiGatewayException
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'fullPhone' => $this->getFullPhone(),
            'isOnlineSigningUpAvailable' => Property::isOnlineSigningUpAvailableForClinic($this->apiGateway, $this->id),
            default => $this->originalDto->$name
        };
    }

    /** @throws VetmanagerApiGatewayException */
    private function getFullPhone(): FullPhone
    {
        $phonePrefix = $this->getClinicPropertyValueFromPropertyName("unisender_phone_pristavka");
        $phoneMask = $this->getClinicPropertyValueFromPropertyName("phone_mask");
        return (new FullPhone($phonePrefix, $this->phone, $phoneMask));
    }

    private function getClinicPropertyValueFromPropertyName(string $propertyName): string
    {
        try {
            $phonePrefixProperty = Property::getByClinicIdAndPropertyName($this->apiGateway, $this->id, "unisender_phone_pristavka");
            return $phonePrefixProperty->value;
        } catch (VetmanagerApiGatewayResponseEmptyException) {
            return "";
        }
    }
}
