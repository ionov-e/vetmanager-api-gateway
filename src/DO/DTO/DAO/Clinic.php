<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO\DTO\DAO;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\DTO\AbstractDTO;
use VetmanagerApiGateway\DO\DTO\DAO;
use VetmanagerApiGateway\DO\DTO\DAO\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\DO\DTO\DAO\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\DO\DTO\DAO\Trait\BasicDAOTrait;
use VetmanagerApiGateway\DO\Enum\ApiRoute;
use VetmanagerApiGateway\DO\Enum\Clinic\Status;
use VetmanagerApiGateway\DO\FullPhone;
use VetmanagerApiGateway\DO\IntContainer;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;

/** @property-read FullPhone $phoneWithPrefixAndNumberAndMask */
final class Clinic extends AbstractDTO implements AllGetRequestsInterface
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
    public ?string $timeZone;
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
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = IntContainer::fromStringOrNull($this->originalData['id'])->positiveInt;
        $this->title = StringContainer::fromStringOrNull($this->originalData['title'])->string;
        $this->address = StringContainer::fromStringOrNull($this->originalData['address'])->string;
        $this->phone = StringContainer::fromStringOrNull($this->originalData['phone'])->string;
        $this->cityId = IntContainer::fromStringOrNull($this->originalData['city_id'])->positiveIntOrNull;
        $this->startTime = StringContainer::fromStringOrNull($this->originalData['start_time'])->string;
        $this->endTime = StringContainer::fromStringOrNull($this->originalData['end_time'])->string;
        $this->internetAddress = StringContainer::fromStringOrNull($this->originalData['internet_address'])->string;
        $this->guestClientId = IntContainer::fromStringOrNull($this->originalData['guest_client_id'])->positiveIntOrNull;
        $this->timeZone = $this->originalData['time_zone'] ? (string)$this->originalData['time_zone'] : null;
        $this->logoUrl = StringContainer::fromStringOrNull($this->originalData['logo_url'])->string;
        $this->status = Status::from($this->originalData['status']);
        $this->telegram = StringContainer::fromStringOrNull($this->originalData['telegram'])->string;
        $this->whatsapp = StringContainer::fromStringOrNull($this->originalData['whatsapp'])->string;
        $this->email = StringContainer::fromStringOrNull($this->originalData['email'])->string;
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
            default => $this->$name,
        };
    }

    /** @throws VetmanagerApiGatewayException */
    private function getFullPhone(int $clinicId): FullPhone
    {
        try {
            $phonePrefixProperty = DAO\Property::getByClinicIdAndPropertyName($this->apiGateway, $clinicId, "unisender_phone_pristavka");
            $phonePrefix = $phonePrefixProperty->value;
        } catch (VetmanagerApiGatewayResponseEmptyException) {
            $phonePrefix = "";
        }

        try {
            $phoneMaskProperty = DAO\Property::getByClinicIdAndPropertyName($this->apiGateway, $clinicId, "phone_mask");
            $phoneMask = $phoneMaskProperty->value;
        } catch (VetmanagerApiGatewayResponseEmptyException) {
            $phoneMask = "";
        }

        return (new FullPhone($phonePrefix, $this->phone, $phoneMask));
    }
}
