<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use DateTime;
use VetmanagerApiGateway\DTO\Enum\Client\Status;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;
use VetmanagerApiGateway\Hydrator\ApiBool;
use VetmanagerApiGateway\Hydrator\ApiDateTime;
use VetmanagerApiGateway\Hydrator\ApiFloat;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;

final class ClientDto // extends AbstractDTO #TODO return
{
    /**
     * @param string|null $email Default: ''
     * @param string|null $date_register В БД бывает дефолтное значение: '0000-00-00 00:00:00'
     * @param string|null $status Default: Active
     * @param string|null $street_id Default: 0
     * @param string|null $apartment Default: ''
     * @param string|null $unsubscribe Default: 0
     * @param string|null $in_blacklist Default: 0
     * @param string|null $last_visit_date В БД бывает дефолтное значение: '0000-00-00 00:00:00'
     * @param string|null $number_of_journal Default: ''
     */
    public function __construct(
        private ?string $id,
        private ?string $address,
        private ?string $home_phone,
        private ?string $work_phone,
        private ?string $note,
        private ?string $type_id,
        private ?string $how_find,
        private ?string $balance,
        private ?string $email,
        private ?string $city,
        private ?string $city_id,
        private ?string $date_register,
        private ?string $cell_phone,
        private ?string $zip,
        private ?string $registration_index,
        private ?string $vip,
        private ?string $last_name,
        private ?string $first_name,
        private ?string $middle_name,
        private ?string $status,
        private ?string $discount,
        private ?string $passport_series,
        private ?string $lab_number,
        private ?string $street_id,
        private ?string $apartment,
        private ?string $unsubscribe,
        private ?string $in_blacklist,
        private ?string $last_visit_date,
        private ?string $number_of_journal,
        private ?string $phone_prefix
    ) {
    }

    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int
    {
        return ApiInt::fromStringOrNull($this->id)->getPositiveInt();
    }

    public function setId(int $id): self
    {
        $this->id = (string)$id;
        return $this;
    }

    public function getAddress(): string
    {
        return ApiString::fromStringOrNull($this->address)->getStringEvenIfNullGiven();
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;
        return $this;
    }

    public function getHomePhone(): string
    {
        return ApiString::fromStringOrNull($this->home_phone)->getStringEvenIfNullGiven();
    }

    public function setHomePhone(string $homePhone): self
    {
        $this->home_phone = $homePhone;
        return $this;
    }

    public function getWorkPhone(): string
    {
        return ApiString::fromStringOrNull($this->work_phone)->getStringEvenIfNullGiven();
    }

    public function setWorkPhone(string $workPhone): self
    {
        $this->work_phone = $workPhone;
        return $this;
    }

    public function getNote(): string
    {
        return ApiString::fromStringOrNull($this->note)->getStringEvenIfNullGiven();
    }

    public function setNote(string $note): self
    {
        $this->note = $note;
        return $this;
    }

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getTypeId(): ?int
    {
        return ApiInt::fromStringOrNull($this->type_id)->getPositiveIntOrNull();
    }

    public function setTypeId(string $type_id): self
    {
        $this->type_id = $type_id;
        return $this;
    }

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getHowFind(): ?int
    {
        return ApiInt::fromStringOrNull($this->how_find)->getPositiveIntOrNull();
    }

    public function setHowFind(string $howFind): self
    {
        $this->how_find = $howFind;
        return $this;
    }

    /** @throws VetmanagerApiGatewayResponseException*/
    public function getBalance(): float
    {
        return ApiFloat::fromStringOrNull($this->balance)->getFloatOrThrow();
    }

    public function setBalance(string $balance): self
    {
        $this->balance = $balance;
        return $this;
    }

    public function getEmail(): string
    {
        return ApiString::fromStringOrNull($this->email)->getStringEvenIfNullGiven();
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getCity(): string
    {
        return ApiString::fromStringOrNull($this->city)->getStringEvenIfNullGiven();
    }

    public function setCity(string $city): self
    {
        $this->city = $city;
        return $this;
    }

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getCityId(): ?int
    {
        return ApiInt::fromStringOrNull($this->city_id)->getPositiveIntOrNull();
    }

    public function setCityId(string $city_id): self
    {
        $this->city_id = $city_id;
        return $this;
    }

    /** Пустые значения переводятся в null
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getDateRegister(): ?DateTime
    {
        return ApiDateTime::fromFullDateTimeString($this->date_register)->getDateTimeOrThrow();
    }

    public function setDateRegister(string $date_register): self
    {
        $this->date_register = $date_register;
        return $this;
    }

    public function getCellPhone(): string
    {
        return ApiString::fromStringOrNull($this->cell_phone)->getStringEvenIfNullGiven();
    }

    public function setCellPhone(string $cell_phone): self
    {
        $this->cell_phone = $cell_phone;
        return $this;
    }

    public function getZip(): string
    {
        return ApiString::fromStringOrNull($this->zip)->getStringEvenIfNullGiven();
    }

    public function setZip(string $zip): self
    {
        $this->zip = $zip;
        return $this;
    }

    public function getRegistrationIndex(): string
    {
        return ApiString::fromStringOrNull($this->registration_index)->getStringEvenIfNullGiven();
    }

    public function setRegistrationIndex(string $registrationIndex): self
    {
        $this->registration_index = $registrationIndex;
        return $this;
    }

    /** Default: 0
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getIsVip(): bool
    {
        return ApiBool::fromStringOrNull($this->vip)->getBoolOrThrowIfNull();
    }

    public function setIsVip(string $vip): self
    {
        $this->vip = $vip;
        return $this;
    }

    public function getLastName(): string
    {
        return ApiString::fromStringOrNull($this->last_name)->getStringEvenIfNullGiven();
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;
        return $this;
    }

    public function getFirstName(): string
    {
        return ApiString::fromStringOrNull($this->first_name)->getStringEvenIfNullGiven();
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;
        return $this;
    }

    public function getMiddleName(): string
    {
        return ApiString::fromStringOrNull($this->middle_name)->getStringEvenIfNullGiven();
    }

    public function setMiddleName(string $middle_name): self
    {
        $this->middle_name = $middle_name;
        return $this;
    }

    public function getStatus(): Status
    {
        return Status::from($this->status);
    }

    public function setStatus(Status $status): self
    {
        $this->status = $status->value;
        return $this;
    }

    /** @throws VetmanagerApiGatewayResponseException */
    public function getDiscount(): int
    {
        return ApiInt::fromStringOrNull($this->discount)->getIntEvenIfNullGiven();
    }

    public function setDiscount(int $discount): self
    {
        $this->discount = (string) $discount;
        return $this;
    }

    public function getPassportSeries(): string
    {
        return ApiString::fromStringOrNull($this->passport_series)->getStringEvenIfNullGiven();
    }

    public function setPassportSeries(string $passport_series): self
    {
        $this->passport_series = $passport_series;
        return $this;
    }

    public function getLabNumber(): string
    {
        return ApiString::fromStringOrNull($this->lab_number)->getStringEvenIfNullGiven();
    }

    public function setLabNumber(string $lab_number): self
    {
        $this->lab_number = $lab_number;
        return $this;
    }

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getStreetId(): ?int
    {
        return ApiInt::fromStringOrNull($this->street_id)->getPositiveIntOrNull();
    }

    public function setStreetId(?int $streetId): self
    {
        $this->street_id = is_null($streetId) ? null : (string)$streetId;
        return $this;
    }

    public function getApartment(): string
    {
        return ApiString::fromStringOrNull($this->apartment)->getStringEvenIfNullGiven();
    }

    public function setApartment(string $apartment): self
    {
        $this->apartment = $apartment;
        return $this;
    }

    /** @throws VetmanagerApiGatewayResponseException */
    public function getIsUnsubscribed(): bool
    {
        return ApiBool::fromStringOrNull($this->unsubscribe)->getBoolOrThrowIfNull();
    }

    public function setUnsubscribe(?bool $isUnsubscribed): self
    {
        $this->unsubscribe = is_null($isUnsubscribed) ? "0" : (int) $isUnsubscribed;
        return $this;
    }

    /** @throws VetmanagerApiGatewayResponseException */
    public function getIsBlacklisted(): bool
    {
        return ApiBool::fromStringOrNull($this->in_blacklist)->getBoolOrThrowIfNull();
    }

    public function setInBlacklist(?bool $isBlacklisted): self
    {
        $this->in_blacklist = is_null($isBlacklisted) ? "0" : (int) $isBlacklisted;
        return $this;
    }

    /** @throws VetmanagerApiGatewayResponseException */
    public function getLastVisitDate(): ?DateTime
    {
        return ApiDateTime::fromFullDateTimeString($this->last_visit_date)->getDateTimeOrThrow();
    }

    /** @throws VetmanagerApiGatewayResponseException
     * @throws VetmanagerApiGatewayException
     */
    public function setLastVisitDateFromSting(?string $lastVisitDate): self
    {
        $this->last_visit_date = is_null($lastVisitDate)
            ? "0000-00-00 00:00:00"
            : ApiDateTime::fromFullDateTimeString($lastVisitDate)->getAsDataBaseStringOrThrowIfNull();
        return $this;
    }

    public function setLastVisitDateFromDateTime(DateTime $lastVisitDate): self
    {
        $this->last_visit_date = $lastVisitDate->format('Y-m-d H:i:s');
        return $this;
    }

    public function getNumberOfJournal(): string
    {
        return ApiString::fromStringOrNull($this->number_of_journal)->getStringEvenIfNullGiven();
    }

    public function setNumberOfJournal(string $numberOfJournal): self
    {
        $this->number_of_journal = $numberOfJournal;
        return $this;
    }

    public function getPhonePrefix(): string
    {
        return ApiString::fromStringOrNull($this->phone_prefix)->getStringEvenIfNullGiven();
    }

    public function setPhonePrefix(string $phonePrefix): self
    {
        $this->phone_prefix = $phonePrefix;
        return $this;
    }
}
