<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\CassaClose;

use DateTime;
use VetmanagerApiGateway\DTO\Payment\StatusEnum;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

/**
 * CREATE TABLE `cassaclose` (
 * `id` int NOT NULL AUTO_INCREMENT,
 * `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
 * `id_cassa` int NOT NULL,
 * `status` enum('exec','save','deleted') NOT NULL DEFAULT 'save',
 * `closed_user_id` int DEFAULT '0',
 * `amount` decimal(25,10) DEFAULT NULL,
 * `amount_cashless` decimal(25,10) NOT NULL DEFAULT '0.0000000000',
 * PRIMARY KEY (`id`),
 * KEY `fk_id_cassa_closedcassa` (`id_cassa`),
 * KEY `fk_closed_user_id_closedcassa` (`closed_user_id`),
 * CONSTRAINT `fk_closed_user_id_closedcassa` FOREIGN KEY (`closed_user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
 * CONSTRAINT `fk_id_cassa_closedcassa` FOREIGN KEY (`id_cassa`) REFERENCES `cassa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3
 */
interface CassaCloseOnlyDtoInterface
{
    /**
     * @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int;

    /**
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getDateAsString(): string;

    /**
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getDateAsDateTime(): DateTime;

    /**
     * @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getCassaId(): int;

    /**
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getStatusAsString(): string;

    public function getStatusAsEnum(): StatusEnum;

    /**
     * @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getClosedUserId(): int;

    public function getAmount(): float;

    /**
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getAmountCashless(): float;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDateFromString(string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDateFromDateTime(DateTime $value): static;

    /**
     * @throws VetmanagerApiGatewayInnerException
     */
    public function setCassaId(int $value): static;

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
    public function setClosedUserId(int $value): static;

    /**
     * @throws VetmanagerApiGatewayInnerException
     */
    public function setAmount(?float $value): static;

    /**
     * @throws VetmanagerApiGatewayInnerException
     */
    public function setAmountCashless(float $value): static;
}
