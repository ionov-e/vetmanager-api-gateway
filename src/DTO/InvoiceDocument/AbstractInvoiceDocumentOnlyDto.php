<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\InvoiceDocument;

use DateTime;
use VetmanagerApiGateway\ApiDataInterpreter\ToBool;
use VetmanagerApiGateway\ApiDataInterpreter\ToDateTime;
use VetmanagerApiGateway\ApiDataInterpreter\ToFloat;
use VetmanagerApiGateway\ApiDataInterpreter\ToInt;
use VetmanagerApiGateway\ApiDataInterpreter\ToString;
use VetmanagerApiGateway\DTO\AbstractDTO;

/** В 2 дочерних классах отличаются типы данных для Quantity & Price. В остальном основа одинаковая. */
abstract class AbstractInvoiceDocumentOnlyDto extends AbstractDTO implements InvoiceDocumentOnlyDtoInterface
{
    /**
     * @param int|string|null $id
     * @param int|string|null $document_id
     * @param int|string|null $good_id
     * @param int|string|null $responsible_user_id
     * @param int|string|null $is_default_responsible
     * @param int|string|null $sale_param_id
     * @param int|string|null $tag_id
     * @param string|null $discount_type
     * @param int|string|null $discount_document_id
     * @param string|null $discount_percent
     * @param string|null $default_price
     * @param string|null $create_date
     * @param string|null $discount_cause
     * @param int|string|null $fixed_discount_id
     * @param int|string|null $fixed_discount_percent
     * @param int|string|null $fixed_increase_id
     * @param int|string|null $fixed_increase_percent
     * @param string|null $prime_cost
     */
    public function __construct(
        protected int|string|null $id,
        protected int|string|null $document_id,
        protected int|string|null $good_id,
        protected int|string|null $responsible_user_id,
        protected int|string|null $is_default_responsible,
        protected int|string|null $sale_param_id,
        protected int|string|null $tag_id,
        protected ?string         $discount_type,
        protected int|string|null $discount_document_id,
        protected ?string         $discount_percent,
        protected ?string         $default_price,
        protected ?string         $create_date,
        protected ?string         $discount_cause,
        protected int|string|null $fixed_discount_id,
        protected int|string|null $fixed_discount_percent,
        protected int|string|null $fixed_increase_id,
        protected int|string|null $fixed_increase_percent,
        protected ?string         $prime_cost
    ) {
    }

    public function getId(): int
    {
        return (ToInt::fromIntOrStringOrNull($this->id))->getPositiveIntOrThrow();
    }

    public function getInvoiceId(): int
    {
        return (ToInt::fromIntOrStringOrNull($this->document_id))->getPositiveIntOrThrow();
    }

    public function getGoodId(): int
    {
        return (ToInt::fromIntOrStringOrNull($this->good_id))->getPositiveIntOrThrow();
    }

    public function getResponsibleUserId(): ?int
    {
        return (ToInt::fromIntOrStringOrNull($this->responsible_user_id))->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function getIsDefaultResponsible(): bool
    {
        return ToBool::fromIntOrNull($this->is_default_responsible)->getBoolOrThrowIfNull();
    }

    public function getSaleParamId(): int
    {
        return (ToInt::fromIntOrStringOrNull($this->sale_param_id))->getPositiveIntOrThrow();
    }

    public function getTagId(): ?int
    {
        return (ToInt::fromIntOrStringOrNull($this->tag_id))->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function getDiscountTypeAsString(): ?string
    {
        return $this->discount_type;
    }

    public function getDiscountTypeAsEnum(): ?DiscountTypeEnum
    {
        return $this->discount_type ? DiscountTypeEnum::from($this->discount_type) : null;
    }

    public function getDiscountDocumentId(): ?int
    {
        return (ToInt::fromIntOrStringOrNull($this->discount_document_id))->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function getDiscountPercent(): ?float
    {
        return ToFloat::fromStringOrNull($this->discount_percent)->getNonZeroFloatOrNull();
    }

    public function getDefaultPrice(): ?float
    {
        return ToFloat::fromStringOrNull($this->default_price)->getNonZeroFloatOrNull();
    }

    public function getCreateDateAsString(): string
    {
        return ToString::fromStringOrNull($this->create_date)->getStringOrThrowIfNull();
    }

    public function getCreateDateAsDateTime(): DateTime
    {
        return ToDateTime::fromOnlyDateString($this->create_date)->getDateTimeOrThrow();
    }

    public function getDiscountCause(): string
    {
        return ToString::fromStringOrNull($this->discount_cause)->getStringEvenIfNullGiven();
    }

    public function getFixedDiscountId(): ?int
    {
        return (ToInt::fromIntOrStringOrNull($this->fixed_discount_id))->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function getFixedDiscountPercent(): ?int
    {
        return (ToInt::fromIntOrStringOrNull($this->fixed_discount_percent))->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function getFixedIncreaseId(): ?int
    {
        return (ToInt::fromIntOrStringOrNull($this->fixed_increase_id))->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function getFixedIncreasePercent(): ?int
    {
        return (ToInt::fromIntOrStringOrNull($this->fixed_increase_percent))->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function getPrimeCost(): float|null
    {
        return ToFloat::fromStringOrNull($this->prime_cost)->getNonZeroFloatOrNull();
    }

    public function setInvoiceId(?int $value): static
    {
        return self::setPropertyFluently($this, 'document_id', $value);
    }

    public function setGoodId(?int $value): static
    {
        return self::setPropertyFluently($this, 'good_id', $value);
    }


    public function setResponsibleUserId(?int $value): static
    {
        return self::setPropertyFluently($this, 'responsible_user_id', $value);
    }

    public function setIsDefaultResponsible(?bool $value): static
    {
        return self::setPropertyFluently($this, 'is_default_responsible', is_null($value) ? null : (int)$value);
    }

    public function setSaleParamId(?int $value): static
    {
        return self::setPropertyFluently($this, 'sale_param_id', $value);
    }

    public function setTagId(?int $value): static
    {
        return self::setPropertyFluently($this, 'tag_id', $value);
    }

    public function setDiscountType(?string $value): static
    {
        return self::setPropertyFluently($this, 'discount_type', $value);
    }

    public function setDiscountDocumentId(?int $value): static
    {
        return self::setPropertyFluently($this, 'discount_document_id', $value);
    }

    public function setDiscountPercent(?float $value): static
    {
        return self::setPropertyFluently($this, 'discount_percent', is_null($value) ? null : (string)$value);
    }

    public function setDefaultPrice(?string $value): static
    {
        return self::setPropertyFluently($this, 'default_price', $value);
    }

    public function setCreateDateFromString(string $value): static
    {
        return self::setPropertyFluently($this, 'create_date', $value);
    }

    public function setCreateDateFromDateTime(DateTime $value): static
    {
        return self::setPropertyFluently($this, 'create_date', $value->format('Y-m-d H:i:s'));
    }

    public function setDiscountCause(?string $value): static
    {
        return self::setPropertyFluently($this, 'discount_cause', $value);
    }

    public function setFixedDiscountId(?int $value): static
    {
        return self::setPropertyFluently($this, 'fixed_discount_id', $value);
    }

    public function setFixedDiscountPercent(?int $value): static
    {
        return self::setPropertyFluently($this, 'fixed_discount_percent', $value);
    }

    public function setFixedIncreaseId(?int $value): static
    {
        return self::setPropertyFluently($this, 'fixed_increase_id', $value);
    }

    public function setFixedIncreasePercent(?int $value): static
    {
        return self::setPropertyFluently($this, 'fixed_increase_percent', $value);
    }

    public function setPrimeCost(?float $value): static
    {
        return self::setPropertyFluently($this, 'prime_cost', is_null($value) ? null : (string)$value);
    }
}
