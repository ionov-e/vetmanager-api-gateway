<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Clinic;

use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;
use VetmanagerApiGateway\Hydrator\DtoPropertyList;

final class ClinicOnlyDto extends AbstractDTO
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
    public StatusEnum $status;
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
        $instance->id = ApiInt::fromStringOrNull($originalDataArray['id'])->getPositiveInt();
        $instance->title = ApiString::fromStringOrNull($originalDataArray['title'])->getStringEvenIfNullGiven();
        $instance->address = ApiString::fromStringOrNull($originalDataArray['address'])->getStringEvenIfNullGiven();
        $instance->phone = ApiString::fromStringOrNull($originalDataArray['phone'])->getStringEvenIfNullGiven();
        $instance->cityId = ApiInt::fromStringOrNull($originalDataArray['city_id'])->getPositiveIntOrNull();
        $instance->startTime = ApiString::fromStringOrNull($originalDataArray['start_time'])->getStringEvenIfNullGiven();
        $instance->endTime = ApiString::fromStringOrNull($originalDataArray['end_time'])->getStringEvenIfNullGiven();
        $instance->internetAddress = ApiString::fromStringOrNull($originalDataArray['internet_address'])->getStringEvenIfNullGiven();
        $instance->guestClientId = ApiInt::fromStringOrNull($originalDataArray['guest_client_id'])->getPositiveIntOrNull();
        $instance->timeZone = ApiString::fromStringOrNull($originalDataArray['time_zone'])->getStringEvenIfNullGiven();
        $instance->logoUrl = ApiString::fromStringOrNull($originalDataArray['logo_url'])->getStringEvenIfNullGiven();
        $instance->status = StatusEnum::from($originalDataArray['status']);
        $instance->telegram = ApiString::fromStringOrNull($originalDataArray['telegram'])->getStringEvenIfNullGiven();
        $instance->whatsapp = ApiString::fromStringOrNull($originalDataArray['whatsapp'])->getStringEvenIfNullGiven();
        $instance->email = ApiString::fromStringOrNull($originalDataArray['email'])->getStringEvenIfNullGiven();
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
