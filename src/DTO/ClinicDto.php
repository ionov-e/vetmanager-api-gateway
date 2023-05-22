<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use VetmanagerApiGateway\DTO\Enum\Clinic\Status;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;
use VetmanagerApiGateway\Hydrator\DtoPropertyList;

/** @psalm-suppress PropertyNotSetInConstructor, RedundantPropertyInitializationCheck - одобрено в доках PSALM для этого случая */
final class ClinicDto extends AbstractDTO
{
    /** @var positive-int */
    public int $id;
    public string $title;
    public string $address;
    public string $phone;
    /** @var ?positive-int */
    public ?int $cityId;
    /** Время вида: "00:00" или пустая строка */
    public string $startTime;
    /** Время вида: 23:45 или пустая строка */
    public string $endTime;
    public string $internetAddress;
    /** @var ?positive-int Default: '0' - переводим в null */
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
     * } $originalDataArray
     * @throws VetmanagerApiGatewayException
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public static function fromApiResponseArray(array $originalDataArray): self
    {
        $instance = new self($originalDataArray);
        $instance->id = ApiInt::fromStringOrNull($originalDataArray['id'])->positiveInt;
        $instance->title = ApiString::fromStringOrNull($originalDataArray['title'])->string;
        $instance->address = ApiString::fromStringOrNull($originalDataArray['address'])->string;
        $instance->phone = ApiString::fromStringOrNull($originalDataArray['phone'])->string;
        $instance->cityId = ApiInt::fromStringOrNull($originalDataArray['city_id'])->positiveIntOrNull;
        $instance->startTime = ApiString::fromStringOrNull($originalDataArray['start_time'])->string;
        $instance->endTime = ApiString::fromStringOrNull($originalDataArray['end_time'])->string;
        $instance->internetAddress = ApiString::fromStringOrNull($originalDataArray['internet_address'])->string;
        $instance->guestClientId = ApiInt::fromStringOrNull($originalDataArray['guest_client_id'])->positiveIntOrNull;
        $instance->timeZone = ApiString::fromStringOrNull($originalDataArray['time_zone'])->string;
        $instance->logoUrl = ApiString::fromStringOrNull($originalDataArray['logo_url'])->string;
        $instance->status = Status::from($originalDataArray['status']);
        $instance->telegram = ApiString::fromStringOrNull($originalDataArray['telegram'])->string;
        $instance->whatsapp = ApiString::fromStringOrNull($originalDataArray['whatsapp'])->string;
        $instance->email = ApiString::fromStringOrNull($originalDataArray['email'])->string;
        return $instance;
    }

    /** @inheritdoc */
    public function getRequiredKeysForPostArray(): array
    {
        return [];
    }

    /** @inheritdoc
     * @throws VetmanagerApiGatewayRequestException
     */
    protected function getSetValuesWithoutId(): array
    {
        return (new DtoPropertyList(
            $this,
            ['title', 'title'],
            ['address', 'address'],
            ['phone', 'phone'],
            ['cityId', 'city_id'],
            ['startTime', 'start_time'],
            ['endTime', 'end_time'],
            ['internetAddress', 'internet_address'],
            ['guestClientId', 'guest_client_id'],
            ['timeZone', 'time_zone'],
            ['logoUrl', 'logo_url'],
            ['status', 'status'],
            ['telegram', 'telegram'],
            ['whatsapp', 'whatsapp'],
            ['email', 'email'],
        ))->toArray();
    }
}
