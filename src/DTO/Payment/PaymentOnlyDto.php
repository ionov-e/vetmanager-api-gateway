<?php

namespace VetmanagerApiGateway\DTO\Payment;

use VetmanagerApiGateway\ApiDataInterpreter\ToDateTime;
use VetmanagerApiGateway\ApiDataInterpreter\ToInt;
use VetmanagerApiGateway\DTO\AbstractDTO;
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
class PaymentOnlyDto extends AbstractDTO
{
    public function __construct(
        public int|string|null $id,
        public ?string         $amount,
        public ?string         $status,
        public int|string|null $cassa_id,
        public int|string|null $cassaclose_id,
        public ?string         $create_date,
        public int|string|null $payed_user,
        public ?string         $description,
        public ?string         $payment_type,
        public int|string|null $invoice_id,
        public int|string|null $parent_id,
    )
    {
    }

    /**
     * @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int
    {
        return (ToInt::fromIntOrStringOrNull($this->id))->getPositiveIntOrThrow();
    }

    /** Бывают отрицательные значения. Пример "1982.0000000000", "-100.0000000000" */
    public function getAmount(): float
    {
        return (float)$this->amount;
    }

    /** В БД предусмотрено, что может быть Null. На практике не видел Null */
    public function getStatusAsString(): ?string
    {
        return $this->status;
    }

    /** В БД предусмотрено, что может быть Null. На практике не видел Null */
    public function getStatusAsEnum(): ?StatusEnum
    {
        return $this->status ? StatusEnum::from($this->status) : null;
    }

    /**
     * @return positive-int В БД Not Null
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getCassaId(): int
    {
        return (ToInt::fromIntOrStringOrNull($this->cassa_id))->getPositiveIntOrThrow();
    }

    /**
     * @return ?positive-int Может быть Null
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getCassaCloseId(): int|null
    {
        return (ToInt::fromIntOrStringOrNull($this->cassaclose_id))->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function getCreateDateAsString(): ?string
    {
        return $this->create_date;
    }

    public function getCreateDateAsDateTime(): ?DateTime
    {
        return ToDateTime::fromOnlyDateString($this->create_date)->getDateTimeOrThrow();
    }

    public function getPayedUser(): int|string|null
    {
        return $this->payed_user;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getPaymentType(): ?string
    {
        return $this->payment_type;
    }

    public function getInvoiceId(): int|string|null
    {
        return $this->invoice_id;
    }

    public function getParentId(): int|string|null
    {
        return $this->parent_id;
    }


    public function setId(int|string|null $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function setAmount(?string $amount): static
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @throws VetmanagerApiGatewayInnerException
     */
    public function setStatusFromString(?string $value): static
    {
        return self::setPropertyFluently($this, 'status', $value);
    }

    /**
     * @throws VetmanagerApiGatewayInnerException
     */
    public function setStatusFromEnum(StatusEnum $value): static
    {
        return self::setPropertyFluently($this, 'status', $value->value);
    }

    public function setCassaId(int|string|null $cassa_id): static
    {
        $this->cassa_id = $cassa_id;
        return $this;
    }

    public function setCassaCloseId(int|string|null $cassaclose_id): static
    {
        $this->cassaclose_id = $cassaclose_id;
        return $this;
    }

    public function setCreateDate(?string $create_date): static
    {
        $this->create_date = $create_date;
        return $this;
    }

    public function setPayedUser(int|string|null $payed_user): static
    {
        $this->payed_user = $payed_user;
        return $this;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function setPaymentType(?string $payment_type): static
    {
        $this->payment_type = $payment_type;
        return $this;
    }

    public function setInvoiceId(int|string|null $invoice_id): static
    {
        $this->invoice_id = $invoice_id;
        return $this;
    }

    public function setParentId(int|string|null $parent_id): static
    {
        $this->parent_id = $parent_id;
        return $this;
    }
}
