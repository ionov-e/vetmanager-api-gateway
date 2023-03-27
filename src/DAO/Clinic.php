<?php declare(strict_types=1);

namespace VetmanagerApiGateway\DAO;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DAO\Interface\AllConstructorsInterface;
use VetmanagerApiGateway\DAO\Trait\AllConstructorsTrait;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\DTO\FullPhone;
use VetmanagerApiGateway\Enum;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;

/** @property-read FullPhone $phoneWithPrefixAndNumberAndMask */
class Clinic extends AbstractDTO implements AllConstructorsInterface
{
    use AllConstructorsTrait;

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
    public Enum\Clinic\Status $status;
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
    readonly protected array $originalData;

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
        $this->status = Enum\Clinic\Status::from($this->originalData['status']);
        $this->telegram = (string)$this->originalData['telegram'];
        $this->whatsapp = (string)$this->originalData['whatsapp'];
        $this->email = (string)$this->originalData['email'];
    }

    public static function getApiModel(): Enum\ApiRoute
    {
        return Enum\ApiRoute::Clinic;
    }

    /**
     * @throws VetmanagerApiGatewayException
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'fullPhone' => self::getFullPhone($this->apiGateway, $this->id),
            default => $this->$name,
        };
    }

    /** @throws VetmanagerApiGatewayException */
    public function getFullPhone(ApiGateway $api, int $clinicId): FullPhone
    {
        try {
            $phonePrefixProperty = Property::fromApiAndClinicIdAndPropertyName($api, $clinicId, "unisender_phone_pristavka");
            $phonePrefix = $phonePrefixProperty->value;
        } catch (VetmanagerApiGatewayResponseEmptyException) {
            $phonePrefix = "";
        }

        try {
            $phoneMaskProperty = Property::fromApiAndClinicIdAndPropertyName($api, $clinicId, "phone_mask");
            $phoneMask = $phoneMaskProperty->value;
        } catch (VetmanagerApiGatewayResponseEmptyException) {
            $phoneMask = "";
        }

        return (new FullPhone($phonePrefix, $this->phone, $phoneMask));
    }
}
