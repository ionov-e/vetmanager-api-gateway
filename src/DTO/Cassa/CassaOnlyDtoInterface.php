<?php

namespace VetmanagerApiGateway\DTO\Cassa;


use DateTime;
use VetmanagerApiGateway\DTO\Payment\StatusEnum;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

/**
 * CREATE TABLE `cassa` (
 * `id` int NOT NULL AUTO_INCREMENT,
 * `title` varchar(255) DEFAULT NULL,
 * `assigned_user_id` int NOT NULL,
 * `inventarization_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 * `client_cass` tinyint(1) DEFAULT '0',
 * `main_cassa` tinyint NOT NULL DEFAULT '0',
 * `is_blocked` int NOT NULL DEFAULT '0',
 * `has_unfinished_docs` int NOT NULL DEFAULT '0',
 * `status` enum('active','deactivated','deleted') NOT NULL DEFAULT 'active',
 * `clinic_id` int NOT NULL DEFAULT '0',
 * `summa_cash` decimal(25,10) NOT NULL DEFAULT '0.0000000000',
 * `summa_cashless` decimal(25,10) NOT NULL DEFAULT '0.0000000000',
 * `is_system` int NOT NULL DEFAULT '0',
 * `show_in_cashflow` int NOT NULL DEFAULT '1',
 * `type` enum('bank','safe','operating') NOT NULL DEFAULT 'safe',
 * `cashless_to_cassa_id` int NOT NULL DEFAULT '0',
 * PRIMARY KEY (`id`),
 * UNIQUE KEY `pk_cassa_title1` (`title`),
 * KEY `i_cassa_clinic_id` (`clinic_id`)
 * ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3
 */
interface CassaOnlyDtoInterface
{
    /**
     * @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int;

    public function getTitle(): string;

    /**
     * @return positive-int ID User, который провел счет
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getAssignedUserId(): int;

    /**
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getInventarizationDateAsString(): string;

    /**
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getInventarizationDateAsDateTime(): DateTime;

    /**
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getIsClientCassa(): ?bool;

    /**
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getIsMainCassa(): bool;

    /**
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getIsBlocked(): bool;

    /**
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getHasUnfinishedDocs(): bool;

    /**
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getStatusAsString(): string;

    public function getStatusAsEnum(): StatusEnum;

    /**
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getClinicId(): int;

    public function getSummaCash(): float;

    public function getSummaCashless(): float;

    /**
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getIsSystem(): bool;

    /**
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getShowInCashFlow(): bool;

    /**
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getTypeAsString(): string;

    public function getTypeAsEnum(): TypeEnum;

    /**
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getCashlessToCassaId(): int;

    /**
     * @throws VetmanagerApiGatewayInnerException
     */
    public function setTitle(?string $value): static;

    /**
     * @throws VetmanagerApiGatewayInnerException
     */
    public function setAssignedUserId(int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setInventarizationDateFromString(string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setInventarizationDateFromDateTime(DateTime $value): static;

    /**
     * @throws VetmanagerApiGatewayInnerException
     */
    public function setIsClientCassa(?bool $value): static;

    /**
     * @throws VetmanagerApiGatewayInnerException
     */
    public function setMainCassa(bool $value): static;

    /**
     * @throws VetmanagerApiGatewayInnerException
     */
    public function setIsBlocked(bool $value): static;

    /**
     * @throws VetmanagerApiGatewayInnerException
     */
    public function setHasUnfinishedDocs(bool $value): static;

    /**
     * @throws VetmanagerApiGatewayInnerException
     */
    public function setStatusFromEnum(StatusEnum $value): static;

    /**
     * @throws VetmanagerApiGatewayInnerException
     */
    public function setStatusFromString(string $value): static;

    /**
     * @throws VetmanagerApiGatewayInnerException
     */
    public function setClinicId(int $value): static;

    /**
     * @throws VetmanagerApiGatewayInnerException
     */
    public function setSummaCash(float $value): static;

    /**
     * @throws VetmanagerApiGatewayInnerException
     */
    public function setSummaCashless(float $value): static;

    /**
     * @throws VetmanagerApiGatewayInnerException
     */
    public function setIsSystem(bool $value): static;

    /**
     * @throws VetmanagerApiGatewayInnerException
     */
    public function setShowInCashFlow(bool $value): static;

    /**
     * @throws VetmanagerApiGatewayInnerException
     */
    public function setTypeFromEnum(TypeEnum $value): static;

    /**
     * @throws VetmanagerApiGatewayInnerException
     */
    public function setTypeFromString(?string $value): static;

    /**
     * @throws VetmanagerApiGatewayInnerException
     */
    public function setCashlessToCassaId(int $value): static;
}