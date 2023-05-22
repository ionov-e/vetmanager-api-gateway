<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use DateTime;
use VetmanagerApiGateway\DTO\Enum\Client\Status;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Hydrator\ApiBool;
use VetmanagerApiGateway\Hydrator\ApiDateTime;
use VetmanagerApiGateway\Hydrator\ApiFloat;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;
use VetmanagerApiGateway\Hydrator\DtoPropertyList;

final class ClientDto extends AbstractDTO
{
    /** @var positive-int */
    public int $id;
    public string $address;
    public string $homePhone;
    public string $workPhone;
    public string $note;
    /** @var ?positive-int */
    public ?int $typeId;
    /** @var ?positive-int */
    public ?int $howFind;
    /** Default: '0.0000000000' */
    public float $balance;
    /** Default: '' */
    public string $email;
    public string $cityTitle;
    /** @var ?positive-int */
    public ?int $cityId;
    /** В БД бывает дефолтное значение: '0000-00-00 00:00:00' - переводится в null */
    public ?DateTime $dateRegister;
    public string $cellPhone;
    public string $zip;
    public string $registrationIndex;
    /** Default: 0 */
    public bool $isVip;
    public string $lastName;
    public string $firstName;
    public string $middleName;
    /** Default: Active */
    public Status $status;
    /** Default: 0 */
    public int $discount;
    public string $passportSeries;
    public string $labNumber;
    /** @var ?positive-int Default: 0 */
    public ?int $streetId;
    /** Default: '' */
    public string $apartment;
    /** Default: 0 */
    public bool $isUnsubscribed;
    /** Default: 0 */
    public bool $isBlacklisted;
    /** В БД бывает дефолтное значение: '0000-00-00 00:00:00' - переводится в null */
    public ?DateTime $lastVisitDate;
    /** Default: '' */
    public string $numberOfJournal;
    public string $phonePrefix;

    /** @param array{
     *      id: string,
     *      address: string,
     *      home_phone: string,
     *      work_phone: string,
     *      note: string,
     *      type_id: ?string,
     *      how_find: ?string,
     *      balance: string,
     *      email: string,
     *      city: string,
     *      city_id: ?string,
     *      date_register: string,
     *      cell_phone: string,
     *      zip: string,
     *      registration_index: ?string,
     *      vip: string,
     *      last_name: string,
     *      first_name: string,
     *      middle_name: string,
     *      status: string,
     *      discount: string,
     *      passport_series: string,
     *      lab_number: string,
     *      street_id: string,
     *      apartment: string,
     *      unsubscribe: string,
     *      in_blacklist: string,
     *      last_visit_date: string,
     *      number_of_journal: string,
     *      phone_prefix: ?string,
     *      city_data?: array,
     *      client_type_data?: array,
     * } $originalDataArray
     * @throws VetmanagerApiGatewayException
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public static function fromApiResponseArray(array $originalDataArray): self
    {
        $instance = new self($originalDataArray);
        $instance->id = ApiInt::fromStringOrNull($originalDataArray['id'])->positiveInt;
        $instance->address = ApiString::fromStringOrNull($originalDataArray['address'])->string;
        $instance->homePhone = ApiString::fromStringOrNull($originalDataArray['home_phone'])->string;
        $instance->workPhone = ApiString::fromStringOrNull($originalDataArray['work_phone'])->string;
        $instance->note = ApiString::fromStringOrNull($originalDataArray['note'])->string;
        $instance->typeId = ApiInt::fromStringOrNull($originalDataArray['type_id'])->positiveIntOrNull;
        $instance->howFind = ApiInt::fromStringOrNull($originalDataArray['how_find'])->positiveIntOrNull;
        $instance->balance = ApiFloat::fromStringOrNull($originalDataArray['balance'])->float;
        $instance->email = ApiString::fromStringOrNull($originalDataArray['email'])->string;
        $instance->cityTitle = ApiString::fromStringOrNull($originalDataArray['city'])->string;
        $instance->cityId = ApiInt::fromStringOrNull($originalDataArray['city_id'])->positiveIntOrNull;
        $instance->dateRegister = ApiDateTime::fromFullDateTimeString($originalDataArray['date_register'])->dateTimeOrNull;
        $instance->cellPhone = ApiString::fromStringOrNull($originalDataArray['cell_phone'])->string;
        $instance->zip = ApiString::fromStringOrNull($originalDataArray['zip'])->string;
        $instance->registrationIndex = ApiString::fromStringOrNull($originalDataArray['registration_index'])->string;
        $instance->isVip = ApiBool::fromStringOrNull($originalDataArray['vip'])->bool;
        $instance->lastName = ApiString::fromStringOrNull($originalDataArray['last_name'])->string;
        $instance->firstName = ApiString::fromStringOrNull($originalDataArray['first_name'])->string;
        $instance->middleName = ApiString::fromStringOrNull($originalDataArray['middle_name'])->string;
        $instance->status = Status::from($originalDataArray['status']);
        $instance->discount = ApiInt::fromStringOrNull($originalDataArray['discount'])->int;
        $instance->passportSeries = ApiString::fromStringOrNull($originalDataArray['passport_series'])->string;
        $instance->labNumber = ApiString::fromStringOrNull($originalDataArray['lab_number'])->string;
        $instance->streetId = ApiInt::fromStringOrNull($originalDataArray['street_id'])->positiveIntOrNull;
        $instance->apartment = ApiString::fromStringOrNull($originalDataArray['apartment'])->string;
        $instance->isUnsubscribed = ApiBool::fromStringOrNull($originalDataArray['unsubscribe'])->bool;
        $instance->isBlacklisted = ApiBool::fromStringOrNull($originalDataArray['in_blacklist'])->bool;
        $instance->lastVisitDate = ApiDateTime::fromFullDateTimeString($originalDataArray['last_visit_date'])->dateTimeOrNull;
        $instance->numberOfJournal = ApiString::fromStringOrNull($originalDataArray['number_of_journal'])->string;
        $instance->phonePrefix = ApiString::fromStringOrNull($originalDataArray['phone_prefix'])->string;
        return $instance;
    }

    /** @inheritdoc */
    public function getRequiredKeysForPostArray(): array #TODO No Idea
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
            ['address', 'address'],
            ['homePhone', 'home_phone'],
            ['workPhone', 'work_phone'],
            ['note', 'note'],
            ['typeId', 'type_id'],
            ['howFind', 'how_find'],
            ['balance', 'balance'],
            ['email', 'email'],
            ['cityTitle', 'city'],
            ['cityId', 'city_id'],
            ['dateRegister', 'date_register'],
            ['cellPhone', 'cell_phone'],
            ['zip', 'zip'],
            ['registrationIndex', 'registration_index'],
            ['isVip', 'vip'],
            ['lastName', 'last_name'],
            ['firstName', 'first_name'],
            ['middleName', 'middle_name'],
            ['status', 'status'],
            ['discount', 'discount'],
            ['passportSeries', 'passport_series'],
            ['labNumber', 'lab_number'],
            ['streetId', 'street_id'],
            ['apartment', 'apartment'],
            ['isUnsubscribed', 'unsubscribe'],
            ['isBlacklisted', 'in_blacklist'],
            ['lastVisitDate', 'last_visit_date'],
            ['numberOfJournal', 'number_of_journal'],
            ['phonePrefix', 'phone_prefix'],
        ))->toArray();
    }
}
