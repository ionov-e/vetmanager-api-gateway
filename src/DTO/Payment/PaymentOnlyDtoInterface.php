<?php

namespace VetmanagerApiGateway\DTO\Payment;


use DateTime;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

/**
 * CREATE TABLE `payment` (
 * `id` int NOT NULL AUTO_INCREMENT,
 * `amount` decimal(25,10) DEFAULT NULL,
 * `status` enum('exec','save','deleted') DEFAULT NULL,
 * `cassa_id` int NOT NULL,
 * `cassaclose_id` int DEFAULT NULL,
 * `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 * `payed_user` int NOT NULL DEFAULT '0',
 * `description` varchar(255) NOT NULL DEFAULT '',
 * `payment_type` varchar(50) NOT NULL DEFAULT 'cash',
 * `invoice_id` int NOT NULL DEFAULT '0',
 * `parent_id` int NOT NULL DEFAULT '0',
 * PRIMARY KEY (`id`),
 * KEY `fk_payment_cassa` (`cassa_id`),
 * KEY `fk_payment_cassaclose` (`cassaclose_id`),
 * KEY `i_payment_create_date` (`create_date`),
 * KEY `i_payment_invoice` (`invoice_id`),
 * CONSTRAINT `fk_payment_cassaclose` FOREIGN KEY (`cassaclose_id`) REFERENCES `cassaclose` (`id`) ON UPDATE CASCADE,
 * CONSTRAINT `fk_payment_cassaclose_to_users` FOREIGN KEY (`cassaclose_id`) REFERENCES `cassaclose` (`id`) ON DELETE SET NULL
 * ) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=COMPRESSED
 */
interface PaymentOnlyDtoInterface
{
    /**
     * @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int;

    /** Бывают отрицательные значения. Пример "1982.0000000000", "-100.0000000000" */
    public function getAmount(): float;

    /** В БД предусмотрено, что может быть Null. На практике не видел Null */
    public function getStatusAsString(): ?string;

    /** В БД предусмотрено, что может быть Null. На практике не видел Null */
    public function getStatusAsEnum(): ?StatusEnum;

    /**
     * @return positive-int В БД Not Null
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getCassaId(): int;

    /**
     * @return ?positive-int Может быть Null
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getCassaCloseId(): int|null;

    /**
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getCreateDateAsString(): string;

    /**
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getCreateDateAsDateTime(): DateTime;

    /**
     * @return positive-int ID User, который провел счет
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getPayedUserId(): int;

    public function getDescription(): string;

    /**
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getPaymentTypeAsString(): string;

    public function getPaymentTypeAsEnum(): PaymentEnum;

    /**
     * @return ?positive-int Видел почему-то 0, что бывает
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getInvoiceId(): int|null;

    /**
     * Если не null значит эта оплата - часть оплаты другой оплаты
     * Пример: есть оплата на аванс на 15000 руб с id - 70 и parent_id - 0
     * А еще будет другая оплата с откушенным счетом на 14000 руб. id, к примеру - 71, parent_id - 70 и комментарием "откушенная оплата ..."
     * @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getParentId(): int|null;

    /**
     * @throws VetmanagerApiGatewayInnerException
     */
    public function setAmount(?float $value): static;

    /**
     * @throws VetmanagerApiGatewayInnerException
     */
    public function setStatusFromString(?string $value): static;

    /**
     * @throws VetmanagerApiGatewayInnerException
     */
    public function setStatusFromEnum(?StatusEnum $value): static;

    /**
     * @throws VetmanagerApiGatewayInnerException
     */
    public function setCassaId(int $value): static;

    /**
     * @throws VetmanagerApiGatewayInnerException
     */
    public function setCassaCloseId(int|null $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCreateDateFromString(string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCreateDateFromDateTime(DateTime $value): static;

    /**
     * @throws VetmanagerApiGatewayInnerException
     */
    public function setPayedUserId(int $value): static;

    /**
     * @throws VetmanagerApiGatewayInnerException
     */
    public function setDescription(string $value): static;

    /**
     * @throws VetmanagerApiGatewayInnerException
     */
    public function setPaymentTypeFromString(?string $value): static;

    /**
     * @throws VetmanagerApiGatewayInnerException
     */
    public function setPaymentTypeFromEnum(?PaymentEnum $value): static;

    /**
     * @param int $value Принимает 0
     * @throws VetmanagerApiGatewayInnerException
     */
    public function setInvoiceId(int $value): static;

    /**
     * @param int $value Принимает 0
     * @throws VetmanagerApiGatewayInnerException
     */
    public function setParentId(int $value): static;
}