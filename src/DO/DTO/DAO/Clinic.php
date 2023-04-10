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
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;

/** @property-read FullPhone $phoneWithPrefixAndNumberAndMask */
class Clinic extends AbstractDTO implements AllGetRequestsInterface
{
    use BasicDAOTrait;
    use AllGetRequestsTrait;

    public int $id;
    public ?string $title;
    public ?string $address;
    public ?string $phone;
    public ?int $cityId;
    /** Пример: "00:00" */
    public ?string $startTime;
    /** Пример: "23:45" */
    public ?string $endTime;
    public ?string $internetAddress;
    /** Default: '0' */
    public int $guestClientId;
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
    /** @var array{
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
     */
    protected readonly array $originalData;

    /**
     * @param ApiGateway $apiGateway
     * @param array $originalData
     * @throws VetmanagerApiGatewayException
     */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = (int)$this->originalData['id'];
        $this->title = $this->originalData['title'] ? (string)$this->originalData['title'] : null;
        $this->address = $this->originalData['address'] ? (string)$this->originalData['address'] : null;
        $this->phone = $this->originalData['phone'] ? (string)$this->originalData['phone'] : null;
        $this->cityId = $this->originalData['city_id'] ? (int)$this->originalData['city_id'] : null;
        $this->startTime = $this->originalData['start_time'] ? (string)$this->originalData['start_time'] : null;
        $this->endTime = $this->originalData['end_time'] ? (string)$this->originalData['end_time'] : null;
        $this->internetAddress = $this->originalData['internet_address'] ? (string)$this->originalData['internet_address'] : null;
        $this->guestClientId = (int)$this->originalData['guest_client_id'];
        $this->timeZone = $this->originalData['time_zone'] ? (string)$this->originalData['time_zone'] : null;
        $this->logoUrl = (string)$this->originalData['logo_url'];
        $this->status = Status::from($this->originalData['status']);
        $this->telegram = (string)$this->originalData['telegram'];
        $this->whatsapp = (string)$this->originalData['whatsapp'];
        $this->email = (string)$this->originalData['email'];
    }

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
