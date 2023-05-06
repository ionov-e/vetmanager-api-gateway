<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\ActiveRecord\Trait\BasicDAOTrait;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\Enum\ApiRoute;
use VetmanagerApiGateway\DO\Enum\Clinic\Status;
use VetmanagerApiGateway\DO\FullPhone;
use VetmanagerApiGateway\DO\IntContainer;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;

/** @property-read FullPhone fullPhone
 * @property-read bool isOnlineSigningUpAvailable
 */
final class Clinic extends AbstractActiveRecord implements AllGetRequestsInterface
{
    use BasicDAOTrait;
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

        $this->id = IntContainer::fromStringOrNull($originalData['id'])->positiveInt;
        $this->title = StringContainer::fromStringOrNull($originalData['title'])->string;
        $this->address = StringContainer::fromStringOrNull($originalData['address'])->string;
        $this->phone = StringContainer::fromStringOrNull($originalData['phone'])->string;
        $this->cityId = IntContainer::fromStringOrNull($originalData['city_id'])->positiveIntOrNull;
        $this->startTime = StringContainer::fromStringOrNull($originalData['start_time'])->string;
        $this->endTime = StringContainer::fromStringOrNull($originalData['end_time'])->string;
        $this->internetAddress = StringContainer::fromStringOrNull($originalData['internet_address'])->string;
        $this->guestClientId = IntContainer::fromStringOrNull($originalData['guest_client_id'])->positiveIntOrNull;
        $this->timeZone = StringContainer::fromStringOrNull($originalData['time_zone'])->string;
        $this->logoUrl = StringContainer::fromStringOrNull($originalData['logo_url'])->string;
        $this->status = Status::from($originalData['status']);
        $this->telegram = StringContainer::fromStringOrNull($originalData['telegram'])->string;
        $this->whatsapp = StringContainer::fromStringOrNull($originalData['whatsapp'])->string;
        $this->email = StringContainer::fromStringOrNull($originalData['email'])->string;
    }

    /** @return ApiRoute::Clinic */
    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::Clinic;
    }

    /**
     * @throws VetmanagerApiGatewayException
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'fullPhone' => $this->getFullPhone($this->id),
            'isOnlineSigningUpAvailable' => Property::isOnlineSigningUpAvailableForClinic($this->apiGateway, $this->id),
            default => $this->$name,
        };
    }

    /** @throws VetmanagerApiGatewayException */
    private function getFullPhone(int $clinicId): FullPhone
    {
        try {
            $phonePrefixProperty = ActiveRecord\Property::getByClinicIdAndPropertyName($this->apiGateway, $clinicId, "unisender_phone_pristavka");
            $phonePrefix = $phonePrefixProperty->value;
        } catch (VetmanagerApiGatewayResponseEmptyException) {
            $phonePrefix = "";
        }

        try {
            $phoneMaskProperty = ActiveRecord\Property::getByClinicIdAndPropertyName($this->apiGateway, $clinicId, "phone_mask");
            $phoneMask = $phoneMaskProperty->value;
        } catch (VetmanagerApiGatewayResponseEmptyException) {
            $phoneMask = "";
        }

        return (new FullPhone($phonePrefix, $this->phone, $phoneMask));
    }
}
