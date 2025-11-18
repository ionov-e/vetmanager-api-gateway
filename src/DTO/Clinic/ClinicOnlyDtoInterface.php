<?php

namespace VetmanagerApiGateway\DTO\Clinic;

use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

interface ClinicOnlyDtoInterface
{
    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int;

    public function getTitle(): string;

    public function getAddress(): string;

    public function getPhone(): string;

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getCityId(): ?int;

    /** Время вида: "00:00" или пустая строка */
    public function getStartTime(): string;

    /** Время вида: 23:45 или пустая строка */
    public function getEndTime(): string;

    public function getInternetAddress(): string;

    /** @return ?positive-int Default: '0' - переводим в null
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getGuestClientId(): ?int;

    /** Пример: "Europe/Kiev" */
    public function getTimeZone(): string;

    /** Default: '' */
    public function getLogoUrl(): string;

    public function getStatusAsEnum(): StatusEnum;

    /** Default: '' */
    public function getTelegram(): string;

    /** Default: '' */
    public function getWhatsapp(): string;

    /** Default: '' */
    public function getEmail(): string;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTitle(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setAddress(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setPhone(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCityId(int $value): static;

    /** Время вида: "00:00" или пустая строка
     * @throws VetmanagerApiGatewayInnerException
     */
    public function setStartTime(?string $value): static;

    /** Время вида: "00:00" или пустая строка
     * @throws VetmanagerApiGatewayInnerException
     */
    public function setEndTime(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setInternetAddress(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setGuestClientId(int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTimeZone(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setLogoUrl(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setStatusFromEnum(\VetmanagerApiGateway\DTO\Client\StatusEnum $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setStatusFromString(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTelegram(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setWhatsapp(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setEmail(?string $value): static;
}
