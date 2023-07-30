<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Client;

use DateTime;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;
use VetmanagerApiGateway\Hydrator\ApiBool;
use VetmanagerApiGateway\Hydrator\ApiDateTime;
use VetmanagerApiGateway\Hydrator\ApiFloat;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;

class ClientOnlyDto extends AbstractDTO implements ClientDtoInterface
{
    /**
     * @param string|null $id
     * @param string|null $address
     * @param string|null $home_phone
     * @param string|null $work_phone
     * @param string|null $note
     * @param string|null $type_id
     * @param string|null $how_find
     * @param string|null $balance
     * @param string|null $email Default: ''
     * @param string|null $city
     * @param string|null $city_id
     * @param string|null $date_register В БД бывает дефолтное значение: '0000-00-00 00:00:00'
     * @param string|null $cell_phone
     * @param string|null $zip
     * @param string|null $registration_index
     * @param string|null $vip
     * @param string|null $last_name
     * @param string|null $first_name
     * @param string|null $middle_name
     * @param string|null $status Default: Active
     * @param string|null $discount
     * @param string|null $passport_series
     * @param string|null $lab_number
     * @param string|null $street_id Default: 0
     * @param string|null $apartment Default: ''
     * @param string|null $unsubscribe Default: 0
     * @param string|null $in_blacklist Default: 0
     * @param string|null $last_visit_date В БД бывает дефолтное значение: '0000-00-00 00:00:00'
     * @param string|null $number_of_journal Default: ''
     * @param string|null $phone_prefix
     */
    public function __construct(
        protected ?string $id,
        protected ?string $address,
        protected ?string $home_phone,
        protected ?string $work_phone,
        protected ?string $note,
        protected ?string $type_id,
        protected ?string $how_find,
        protected ?string $balance,
        protected ?string $email,
        protected ?string $city,
        protected ?string $city_id,
        protected ?string $date_register,
        protected ?string $cell_phone,
        protected ?string $zip,
        protected ?string $registration_index,
        protected ?string $vip,
        protected ?string $last_name,
        protected ?string $first_name,
        protected ?string $middle_name,
        protected ?string $status,
        protected ?string $discount,
        protected ?string $passport_series,
        protected ?string $lab_number,
        protected ?string $street_id,
        protected ?string $apartment,
        protected ?string $unsubscribe,
        protected ?string $in_blacklist,
        protected ?string $last_visit_date,
        protected ?string $number_of_journal,
        protected ?string $phone_prefix
    )
    {
    }

    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int
    {
        return ApiInt::fromStringOrNull($this->id)->getPositiveInt();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setId(int $value): static
    {
        return self::setPropertyFluently($this, 'id', (string)$value);
    }

    public function getAddress(): string
    {
        return ApiString::fromStringOrNull($this->address)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setAddress(string $value): static
    {
        return self::setPropertyFluently($this, 'address', $value);
    }

    public function getHomePhone(): string
    {
        return ApiString::fromStringOrNull($this->home_phone)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setHomePhone(string $value): static
    {
        return self::setPropertyFluently($this, 'home_phone', $value);
    }

    public function getWorkPhone(): string
    {
        return ApiString::fromStringOrNull($this->work_phone)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setWorkPhone(string $value): static
    {
        return self::setPropertyFluently($this, 'work_phone', $value);
    }

    public function getNote(): string
    {
        return ApiString::fromStringOrNull($this->note)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setNote(string $value): static
    {
        return self::setPropertyFluently($this, 'note', $value);
    }

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getTypeId(): ?int
    {
        return ApiInt::fromStringOrNull($this->type_id)->getPositiveIntOrNull();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTypeId(string $value): static
    {
        return self::setPropertyFluently($this, 'type_id', $value);
    }

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getHowFind(): ?int
    {
        return ApiInt::fromStringOrNull($this->how_find)->getPositiveIntOrNull();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setHowFind(string $value): static
    {
        return self::setPropertyFluently($this, 'how_find', $value);
    }

    /** @throws VetmanagerApiGatewayResponseException */
    public function getBalance(): float
    {
        return ApiFloat::fromStringOrNull($this->balance)->getFloatOrThrow();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setBalance(string $value): static
    {
        return self::setPropertyFluently($this, 'balance', $value);
    }

    public function getEmail(): string
    {
        return ApiString::fromStringOrNull($this->email)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setEmail(string $value): static
    {
        return self::setPropertyFluently($this, 'email', $value);
    }

    public function getCityTitle(): string
    {
        return ApiString::fromStringOrNull($this->city)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCityTitle(string $value): static
    {
        return self::setPropertyFluently($this, 'city', $value);
    }

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getCityId(): ?int
    {
        return ApiInt::fromStringOrNull($this->city_id)->getPositiveIntOrNull();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCityId(string $value): static
    {
        return self::setPropertyFluently($this, 'city_id', $value);
    }

    /** Пустые значения переводятся в null
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getDateRegister(): ?DateTime
    {
        return ApiDateTime::fromFullDateTimeString($this->date_register)->getDateTimeOrThrow();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDateRegister(string $value): static
    {
        return self::setPropertyFluently($this, 'date_register', $value);
    }

    public function getCellPhone(): string
    {
        return ApiString::fromStringOrNull($this->cell_phone)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCellPhone(string $value): static
    {
        return self::setPropertyFluently($this, 'cell_phone', $value);
    }

    public function getZip(): string
    {
        return ApiString::fromStringOrNull($this->zip)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setZip(string $value): static
    {
        return self::setPropertyFluently($this, 'zip', $value);
    }

    public function getRegistrationIndex(): string
    {
        return ApiString::fromStringOrNull($this->registration_index)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setRegistrationIndex(string $value): static
    {
        return self::setPropertyFluently($this, 'registration_index', $value);
    }

    /** Default: 0
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getIsVip(): bool
    {
        return ApiBool::fromStringOrNull($this->vip)->getBoolOrThrowIfNull();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setIsVip(string $value): static
    {
        return self::setPropertyFluently($this, 'vip', $value);
    }

    public function getLastName(): string
    {
        return ApiString::fromStringOrNull($this->last_name)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setLastName(string $value): static
    {
        return self::setPropertyFluently($this, 'last_name', $value);
    }

    public function getFirstName(): string
    {
        return ApiString::fromStringOrNull($this->first_name)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setFirstName(string $value): static
    {
        return self::setPropertyFluently($this, 'first_name', $value);
    }

    public function getMiddleName(): string
    {
        return ApiString::fromStringOrNull($this->middle_name)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setMiddleName(string $value): static
    {
        return self::setPropertyFluently($this, 'middle_name', $value);
    }

    public function getStatus(): StatusEnum
    {
        return StatusEnum::from($this->status);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setStatus(StatusEnum $value): static
    {
        return self::setPropertyFluently($this, 'status', $value->value);
    }

    /** @throws VetmanagerApiGatewayResponseException */
    public function getDiscount(): int
    {
        return ApiInt::fromStringOrNull($this->discount)->getIntEvenIfNullGiven();
    }


    /** @throws VetmanagerApiGatewayInnerException */
    public function setDiscount(int $value): static
    {
        return self::setPropertyFluently($this, 'discount', (string)$value);
    }

    public function getPassportSeries(): string
    {
        return ApiString::fromStringOrNull($this->passport_series)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setPassportSeries(string $value): static
    {
        return self::setPropertyFluently($this, 'passport_series', $value);
    }

    public function getLabNumber(): string
    {
        return ApiString::fromStringOrNull($this->lab_number)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setLabNumber(string $value): static
    {
        return self::setPropertyFluently($this, 'lab_number', $value);
    }

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getStreetId(): ?int
    {
        return ApiInt::fromStringOrNull($this->street_id)->getPositiveIntOrNull();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setStreetId(?int $value): static
    {
        return self::setPropertyFluently(
            $this,
            'streetId',
            is_null($value) ? null : (string)$value
        );
    }

    public function getApartment(): string
    {
        return ApiString::fromStringOrNull($this->apartment)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setApartment(string $value): static
    {
        return self::setPropertyFluently($this, 'apartment', $value);
    }

    /** @throws VetmanagerApiGatewayResponseException */
    public function getIsUnsubscribed(): bool
    {
        return ApiBool::fromStringOrNull($this->unsubscribe)->getBoolOrThrowIfNull();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setUnsubscribe(bool $value): static
    {
        return self::setPropertyFluently($this, 'unsubscribe', (string)(int)$value);
    }

    /** @throws VetmanagerApiGatewayResponseException */
    public function getIsBlacklisted(): bool
    {
        return ApiBool::fromStringOrNull($this->in_blacklist)->getBoolOrThrowIfNull();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setInBlacklist(bool $value): static
    {
        return self::setPropertyFluently($this, 'in_blacklist', (string)(int)$value);
    }

    /** @throws VetmanagerApiGatewayResponseException */
    public function getLastVisitDate(): ?DateTime
    {
        return ApiDateTime::fromFullDateTimeString($this->last_visit_date)->getDateTimeOrThrow();
    }

    /** @throws VetmanagerApiGatewayResponseException
     * @throws VetmanagerApiGatewayException
     */
    public function setLastVisitDateFromSting(?string $value): static
    {
        $value = is_null($value)
            ? "0000-00-00 00:00:00"
            : ApiDateTime::fromFullDateTimeString($value)->getAsDataBaseStringOrThrowIfNull();
        return self::setPropertyFluently(
            $this,
            'last_visit_date',
            $value
        );
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setLastVisitDateFromDateTime(DateTime $value): static
    {
        return self::setPropertyFluently($this, 'last_visit_date', $value->format('Y-m-d H:i:s'));
    }

    public function getNumberOfJournal(): string
    {
        return ApiString::fromStringOrNull($this->number_of_journal)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setNumberOfJournal(string $value): static
    {
        return self::setPropertyFluently($this, 'number_of_journal', $value);
    }

    public function getPhonePrefix(): string
    {
        return ApiString::fromStringOrNull($this->phone_prefix)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setPhonePrefix(string $value): static
    {
        return self::setPropertyFluently($this, 'phone_prefix', $value);
    }
}
