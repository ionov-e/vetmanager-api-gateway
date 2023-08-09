<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Good;

use DateTime;
use VetmanagerApiGateway\ApiDataInterpreter\ToBool;
use VetmanagerApiGateway\ApiDataInterpreter\ToDateTime;
use VetmanagerApiGateway\ApiDataInterpreter\ToFloat;
use VetmanagerApiGateway\ApiDataInterpreter\ToInt;
use VetmanagerApiGateway\ApiDataInterpreter\ToString;
use VetmanagerApiGateway\DTO\AbstractDTO;

class GoodOnlyDto extends AbstractDTO implements GoodOnlyDtoInterface
{
    /**
     * @param string|null $id
     * @param string|null $group_id
     * @param string|null $title
     * @param string|null $unit_storage_id
     * @param string|null $is_warehouse_account
     * @param string|null $is_active
     * @param string|null $code
     * @param string|null $is_call
     * @param string|null $is_for_sale
     * @param string|null $barcode
     * @param string|null $create_date
     * @param string|null $description
     * @param string|null $prime_cost
     * @param string|null $category_id
     */
    public function __construct(
        protected ?string $id,
        protected ?string $group_id,
        protected ?string $title,
        protected ?string $unit_storage_id,
        protected ?string $is_warehouse_account,
        protected ?string $is_active,
        protected ?string $code,
        protected ?string $is_call,
        protected ?string $is_for_sale,
        protected ?string $barcode,
        protected ?string $create_date,
        protected ?string $description,
        protected ?string $prime_cost,
        protected ?string $category_id
    ) {
    }

    public function getId(): int
    {
        return ToInt::fromStringOrNull($this->id)->getPositiveIntOrThrow();
    }

    public function getGroupId(): ?int
    {
        return ToInt::fromStringOrNull($this->group_id)->getPositiveIntOrNullOrThrowIfNegative();

    }

    public function getTitle(): string
    {
        return ToString::fromStringOrNull($this->title)->getStringEvenIfNullGiven();
    }

    public function getUnitId(): ?int
    {
        return ToInt::fromStringOrNull($this->unit_storage_id)->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function getIsWarehouseAccount(): bool
    {
        return ToBool::fromStringOrNull($this->is_warehouse_account)->getBoolOrThrowIfNull();
    }

    public function getIsActive(): bool
    {
        return ToBool::fromStringOrNull($this->is_active)->getBoolOrThrowIfNull();
    }

    public function getCode(): string
    {
        return ToString::fromStringOrNull($this->code)->getStringEvenIfNullGiven();
    }

    public function getIsCall(): bool
    {
        return ToBool::fromStringOrNull($this->is_call)->getBoolOrThrowIfNull();
    }

    public function getIsForSale(): bool
    {
        return ToBool::fromStringOrNull($this->is_for_sale)->getBoolOrThrowIfNull();
    }

    public function getBarcode(): string
    {
        return ToString::fromStringOrNull($this->barcode)->getStringEvenIfNullGiven();
    }

    public function getCreateDate(): ?DateTime
    {
        return ToDateTime::fromOnlyDateString($this->create_date)->getDateTimeOrThrow();
    }

    public function getDescription(): string
    {
        return ToString::fromStringOrNull($this->description)->getStringEvenIfNullGiven();
    }

    public function getPrimeCost(): float
    {
        return ToFloat::fromStringOrNull($this->prime_cost)->getNonZeroFloatOrNull();
    }

    public function getCategoryId(): ?int
    {
        return ToInt::fromStringOrNull($this->category_id)->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function setId(?int $value): static
    {
        return self::setPropertyFluently($this, 'id', is_null($value) ? null : (string)$value);
    }

    public function setGroupId(?int $value): static
    {
        return self::setPropertyFluently($this, 'group_id', is_null($value) ? null : (string)$value);
    }

    public function setTitle(?string $value): static
    {
        return self::setPropertyFluently($this, 'title', $value);
    }

    public function setUnitStorageId(?int $value): static
    {
        return self::setPropertyFluently($this, 'unit_storage_id', is_null($value) ? null : (string)$value);
    }

    public function setIsWarehouseAccount(?bool $value): static
    {
        return self::setPropertyFluently($this, 'is_warehouse_account', is_null($value) ? null : (string)(int)$value);
    }

    public function setIsActive(?bool $value): static
    {
        return self::setPropertyFluently($this, 'is_active', is_null($value) ? null : (string)(int)$value);
    }

    public function setCode(?string $value): static
    {
        return self::setPropertyFluently($this, 'code', $value);
    }

    public function setIsCall(?bool $value): static
    {
        return self::setPropertyFluently($this, 'is_call', is_null($value) ? null : (string)(int)$value);
    }

    public function setIsForSale(?bool $value): static
    {
        return self::setPropertyFluently($this, 'is_for_sale', is_null($value) ? null : (string)(int)$value);
    }

    public function setBarcode(?string $value): static
    {
        return self::setPropertyFluently($this, 'barcode', $value);
    }

    public function setCreateDateFromString(?string $value): static
    {
        return self::setPropertyFluently($this, 'create_date', $value);
    }

    public function setCreateDateFromDateTime(DateTime $value): static
    {
        return self::setPropertyFluently($this, 'create_date', $value->format('Y-m-d H:i:s'));
    }

    public function setDescription(?string $value): static
    {
        return self::setPropertyFluently($this, 'description', $value);
    }

    public function setPrimeCost(?float $value): static
    {
        return self::setPropertyFluently($this, 'prime_cost', is_null($value) ? null : (string)$value);
    }

    public function setCategoryId(?int $value): static
    {
        return self::setPropertyFluently($this, 'category_id', is_null($value) ? null : (string)$value);
    }

//    /** @param array{
//     *     id: numeric-string,
//     *     group_id: ?numeric-string,
//     *     title: string,
//     *     unit_storage_id: ?numeric-string,
//     *     is_warehouse_account: string,
//     *     is_active: string,
//     *     code: ?string,
//     *     is_call: string,
//     *     is_for_sale: string,
//     *     barcode: ?string,
//     *     create_date: string,
//     *     description: string,
//     *     prime_cost: string,
//     *     category_id: ?numeric-string,
//     *     group?: array,
//     *     unitStorage?: array,
//     *     goodSaleParams?: array
//     * } $originalDataArray
//     */
}
