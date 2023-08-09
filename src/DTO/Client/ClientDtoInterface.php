<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Client;

use DateTime;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

interface ClientDtoInterface
{
    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setId(int $value);

    public function getAddress(): string;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setAddress(string $value): static;

    public function getHomePhone(): string;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setHomePhone(string $value): static;

    public function getWorkPhone(): string;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setWorkPhone(string $value): static;

    public function getNote(): string;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setNote(string $value): static;

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getTypeId(): ?int;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTypeId(string $value): static;

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getHowFind(): ?int;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setHowFind(string $value): static;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getBalance(): float;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setBalance(string $value): static;

    public function getEmail(): string;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setEmail(string $value): static;

    public function getCityTitle(): string;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCityTitle(string $value): static;

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getCityId(): ?int;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCityId(string $value): static;

    /** Пустые значения переводятся в null
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getDateRegisterAsDateTime(): ?DateTime;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDateRegisterFromString(string $value): static;

    public function setDateRegisterFromDateTime(DateTime $value): static;

    public function getCellPhone(): string;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCellPhone(string $value): static;

    public function getZip(): string;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setZip(string $value): static;

    public function getRegistrationIndex(): string;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setRegistrationIndex(string $value): static;

    /** Default: 0
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getIsVip(): bool;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setIsVip(string $value): static;

    public function getLastName(): string;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setLastName(string $value): static;

    public function getFirstName(): string;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setFirstName(string $value): static;

    public function getMiddleName(): string;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setMiddleName(string $value): static;

    public function getStatus(): StatusEnum;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setStatus(StatusEnum $value): static;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getDiscount(): int;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDiscount(int $value): static;

    public function getPassportSeries(): string;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setPassportSeries(string $value): static;

    public function getLabNumber(): string;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setLabNumber(string $value): static;

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getStreetId(): ?int;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setStreetId(?int $value): static;

    public function getApartment(): string;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setApartment(string $value): static;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getIsUnsubscribed(): bool;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setUnsubscribe(bool $value): static;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getIsBlacklisted(): bool;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setInBlacklist(bool $value): static;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getLastVisitDate(): ?DateTime;

    /** @throws VetmanagerApiGatewayResponseException
     * @throws VetmanagerApiGatewayException
     */
    public function setLastVisitDateFromSting(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setLastVisitDateFromDateTime(DateTime $value): static;

    public function getNumberOfJournal(): string;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setNumberOfJournal(string $value): static;

    public function getPhonePrefix(): string;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setPhonePrefix(string $value): static;
}