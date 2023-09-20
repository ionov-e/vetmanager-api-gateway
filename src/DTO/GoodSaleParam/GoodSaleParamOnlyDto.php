<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\GoodSaleParam;

use VetmanagerApiGateway\ApiDataInterpreter\ToFloat;
use VetmanagerApiGateway\ApiDataInterpreter\ToInt;
use VetmanagerApiGateway\ApiDataInterpreter\ToString;
use VetmanagerApiGateway\DTO\AbstractDTO;

class GoodSaleParamOnlyDto extends AbstractDTO implements GoodSaleParamOnlyDtoInterface
{
    /**
     * @param int|null $id
     * @param int|null $good_id Default: 0
     * @param string|null $price
     * @param int|null $coefficient Default: 1
     * @param int|null $unit_sale_id Default: 0
     * @param string|null $min_price
     * @param string|null $max_price
     * @param string|null $barcode
     * @param string|null $status Default: 'active'
     * @param int|null $clinic_id Default: 0
     * @param string|null $markup
     * @param string|null $price_formation Default: 'fixed'
     */
    public function __construct(
        protected ?int $id,
        protected ?int $good_id,
        protected ?string $price,
        protected ?int $coefficient,
        protected ?int $unit_sale_id,
        protected ?string $min_price,
        protected ?string $max_price,
        protected ?string $barcode,
        protected ?string $status,
        protected ?int $clinic_id,
        protected ?string $markup,
        protected ?string $price_formation
    ) {
    }

    public function getId(): int
    {
        return (new ToInt($this->id))->getPositiveIntOrThrow();
    }

    public function getGoodId(): ?int
    {
        return (new ToInt($this->good_id))->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function getPrice(): ?float
    {
        return ToFloat::fromStringOrNull($this->price)->getNonZeroFloatOrNull();
    }

    public function getCoefficient(): float
    {
        return ToFloat::fromStringOrNull($this->coefficient)->getNonZeroFloatOrNull();
    }

    public function getUnitSaleId(): ?int
    {
        return (new ToInt($this->unit_sale_id))->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function getMinPrice(): ?float
    {
        return ToFloat::fromStringOrNull($this->min_price)->getNonZeroFloatOrNull();
    }

    public function getMaxPrice(): ?float
    {
        return ToFloat::fromStringOrNull($this->max_price)->getNonZeroFloatOrNull();
    }

    public function getBarcode(): string
    {
        return ToString::fromStringOrNull($this->barcode)->getStringEvenIfNullGiven();
    }

    public function getStatus(): \VetmanagerApiGateway\DTO\GoodSaleParam\StatusEnum
    {
        return StatusEnum::from($this->status);
    }

    public function getClinicId(): ?int
    {
        return (new ToInt($this->clinic_id))->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function getMarkup(): ?float
    {
        return ToFloat::fromStringOrNull($this->markup)->getNonZeroFloatOrNull();
    }

    public function getPriceFormationAsEnum(): PriceFormationEnum
    {
        return PriceFormationEnum::from((string)$this->price_formation);
    }

    public function setGoodId(?string $value): static
    {
        return self::setPropertyFluently($this, 'good_id', $value);
    }

    public function setPrice(?float $value): static
    {
        return self::setPropertyFluently($this, 'price', is_null($value) ? null : (string)$value);
    }

    public function setCoefficient(?float $value): static
    {
        return self::setPropertyFluently($this, 'coefficient', is_null($value) ? null : (string)$value);
    }

    public function setUnitSaleId(?int $value): static
    {
        return self::setPropertyFluently($this, 'unit_sale_id', $value);
    }

    public function setMinPrice(?float $value): static
    {
        return self::setPropertyFluently($this, 'min_price', is_null($value) ? null : (string)$value);
    }

    public function setMaxPrice(?float $value): static
    {
        return self::setPropertyFluently($this, 'max_price', is_null($value) ? null : (string)$value);
    }

    public function setBarcode(?string $value): static
    {
        return self::setPropertyFluently($this, 'barcode', $value);
    }

    public function setStatusFromString(?string $value): static
    {
        return self::setPropertyFluently($this, 'status', $value);
    }

    public function setStatusFromEnum(StatusEnum $value): static
    {
        return self::setPropertyFluently($this, 'status', $value->value); 
    }

    public function setClinicId(?string $value): static
    {
        return self::setPropertyFluently($this, 'clinic_id', is_null($value) ? null : $value);
    }

    public function setMarkup(?float $value): static
    {
        return self::setPropertyFluently($this, 'markup', is_null($value) ? null : (string)$value);
    }

    public function setPriceFormationFromString(?string $value): static
    {
        return self::setPropertyFluently($this, 'price_formation', $value);
    }

    public function setPriceFormationFromEnum(PriceFormationEnum $value): static
    {
        return self::setPropertyFluently($this, 'price_formation', $value->value);
    }

//    /** @param array{
//     *     id: numeric-string,
//     *     good_id: numeric-string,
//     *     price: ?string,
//     *     coefficient: string,
//     *     unit_sale_id: numeric-string,
//     *     min_price: ?string,
//     *     max_price: ?string,
//     *     barcode: ?string,
//     *     status: string,
//     *     clinic_id: numeric-string,
//     *     markup: string,
//     *     price_formation: ?string,
//     *     unitSale?: array,
//     *     good?: array
//     * } $originalDataArray
//     */
}
