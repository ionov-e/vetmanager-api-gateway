<?php

namespace VetmanagerApiGateway\DTO\User;

use DateTime;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

interface UserOnlyDtoInterface
{
    /** @throws VetmanagerApiGatewayResponseException */
    public function getId(): int;

    public function getLastName(): string;

    public function getFirstName(): string;

    public function getMiddleName(): string;

    public function getLogin(): string;

    public function getPassword(): string;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getPositionId(): int;

    public function getEmail(): string;

    public function getPhone(): string;

    public function getCellPhone(): string;

    public function getAddress(): string;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getRoleId(): ?int;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getIsActive(): bool;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getIsPercentCalculated(): bool;

    public function getNickname(): string;

    public function getLastChangePwdDateAsString(): ?string;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getLastChangePwdDateAsDateTime(): ?DateTime;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getIsLimited(): bool;

    /** Идентифицирующий ключ пользователя (прежде всего в Dashly используется) */
    public function getCarrotQuestId(): string;

    public function getSipNumber(): string;

    public function getUserInn(): string;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setLastName(string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setFirstName(string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setMiddleName(string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setLogin(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setPasswd(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setPositionId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setEmail(?string $value): static;

    public function setPhone(?string $value): static;

    public function setCellPhone(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setAddress(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setRoleId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setIsActive(?bool $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCalcPercents(?float $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setNickname(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setLastChangePwdDateFromString(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setLastChangePwdDateFromDateTime(DateTime $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setIsLimited(?bool $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCarrotQuestId(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setSipNumber(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setUserInn(?string $value): static;
}