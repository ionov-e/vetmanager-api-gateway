<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Payment;

use DateTime;
use VetmanagerApiGateway\ApiDataInterpreter\ToDateTime;
use VetmanagerApiGateway\ApiDataInterpreter\ToInt;
use VetmanagerApiGateway\ApiDataInterpreter\ToString;
use VetmanagerApiGateway\DTO\AbstractDTO;

class PaymentOnlyDto extends AbstractDTO implements PaymentOnlyDtoInterface
{
    /**
     * @param int|string|null $id
     * @param string|null $amount
     * @param string|null $status
     * @param int|string|null $cassa_id
     * @param int|string|null $cassaclose_id
     * @param string|null $create_date
     * @param int|string|null $payed_user
     * @param string|null $description
     * @param string|null $payment_type
     * @param int|string|null $invoice_id
     * @param int|string|null $parent_id
     */
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
    ) {
    }

    public function getId(): int
    {
        return (ToInt::fromIntOrStringOrNull($this->id))->getPositiveIntOrThrow();
    }

    public function getAmount(): float
    {
        return (float)$this->amount;
    }

    public function getStatusAsString(): ?string
    {
        return $this->status;
    }

    public function getStatusAsEnum(): ?StatusEnum
    {
        return $this->status ? StatusEnum::from($this->status) : null;
    }

    public function getCassaId(): int
    {
        return (ToInt::fromIntOrStringOrNull($this->cassa_id))->getPositiveIntOrThrow();
    }

    public function getCassaCloseId(): int|null
    {
        return (ToInt::fromIntOrStringOrNull($this->cassaclose_id))->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function getCreateDateAsString(): string
    {
        return (ToString::fromStringOrNull($this->create_date))->getStringOrThrowIfNull();
    }

    public function getCreateDateAsDateTime(): DateTime
    {
        return ToDateTime::fromOnlyDateString($this->create_date)->getDateTimeOrThrow();
    }

    public function getPayedUserId(): int
    {
        return (ToInt::fromIntOrStringOrNull($this->payed_user))->getPositiveIntOrThrow();
    }

    public function getDescription(): string
    {
        return (ToString::fromStringOrNull($this->description))->getStringEvenIfNullGiven();
    }

    public function getPaymentTypeAsString(): string
    {
        return (ToString::fromStringOrNull($this->payment_type))->getStringOrThrowIfNull();
    }

    public function getPaymentTypeAsEnum(): PaymentEnum
    {
        return PaymentEnum::from($this->payment_type);
    }

    public function getInvoiceId(): int|null
    {
        return (ToInt::fromIntOrStringOrNull($this->invoice_id))->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function getParentId(): int|null
    {
        return (ToInt::fromIntOrStringOrNull($this->parent_id))->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function setAmount(?float $value): static
    {
        return self::setPropertyFluently($this, 'amount', $value);
    }

    public function setStatusFromString(?string $value): static
    {
        return self::setPropertyFluently($this, 'status', $value);
    }

    public function setStatusFromEnum(?StatusEnum $value): static
    {
        return self::setPropertyFluently($this, 'status', $value?->value);
    }

    public function setCassaId(int $value): static
    {
        return self::setPropertyFluently($this, 'cassa_id', $value);
    }

    public function setCassaCloseId(int|null $value): static
    {
        return self::setPropertyFluently($this, 'cassaclose_id', $value);
    }

    public function setCreateDateFromString(string $value): static
    {
        return self::setPropertyFluently($this, 'create_date', $value);
    }

    public function setCreateDateFromDateTime(DateTime $value): static
    {
        return self::setPropertyFluently($this, 'create_date', $value->format('Y-m-d H:i:s'));
    }

    public function setPayedUserId(int $value): static
    {
        return self::setPropertyFluently($this, 'payed_user', $value);
    }

    public function setDescription(string $value): static
    {
        return self::setPropertyFluently($this, 'description', $value);
    }

    public function setPaymentTypeFromString(?string $value): static
    {
        return self::setPropertyFluently($this, 'payment_type', $value);
    }

    public function setPaymentTypeFromEnum(?PaymentEnum $value): static
    {
        return self::setPropertyFluently($this, 'payment_type', $value?->value);
    }

    public function setInvoiceId(int $value): static
    {
        return self::setPropertyFluently($this, 'invoice_id', $value);
    }

    public function setParentId(int $value): static
    {
        return self::setPropertyFluently($this, 'parent_id', $value);
    }
}
