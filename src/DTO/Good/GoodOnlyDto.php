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
     * @param int|string|null $id
     * @param int|string|null $group_id
     * @param string|null $title
     * @param int|string|null $unit_storage_id
     * @param int|string|null $is_warehouse_account
     * @param int|string|null $is_active
     * @param string|null $code
     * @param int|string|null $is_call
     * @param int|string|null $is_for_sale
     * @param string|null $barcode
     * @param string|null $create_date
     * @param string|null $description
     * @param string|null $prime_cost
     * @param int|string|null $category_id
     */
    public function __construct(
        protected int|string|null $id,
        protected int|string|null $group_id,
        protected ?string         $title,
        protected int|string|null $unit_storage_id,
        protected int|string|null $is_warehouse_account,
        protected int|string|null $is_active,
        protected ?string         $code,
        protected int|string|null $is_call,
        protected int|string|null $is_for_sale,
        protected ?string         $barcode,
        protected ?string         $create_date,
        protected ?string         $description,
        protected ?string         $prime_cost,
        protected int|string|null $category_id
    ) {
    }

    public function getId(): int
    {
        return (ToInt::fromIntOrStringOrNull($this->id))->getPositiveIntOrThrow();
    }

    public function getGroupId(): ?int
    {
        return (ToInt::fromIntOrStringOrNull($this->group_id))->getPositiveIntOrNullOrThrowIfNegative();

    }

    public function getTitle(): string
    {
        return ToString::fromStringOrNull($this->title)->getStringEvenIfNullGiven();
    }

    public function getUnitId(): ?int
    {
        return (ToInt::fromIntOrStringOrNull($this->unit_storage_id))->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function getIsWarehouseAccount(): bool
    {
        return ToBool::fromIntOrNull($this->is_warehouse_account)->getBoolOrThrowIfNull();
    }

    public function getIsActive(): bool
    {
        return ToBool::fromIntOrNull($this->is_active)->getBoolOrThrowIfNull();
    }

    public function getCode(): string
    {
        return ToString::fromStringOrNull($this->code)->getStringEvenIfNullGiven();
    }

    public function getIsCall(): bool
    {
        return ToBool::fromIntOrNull($this->is_call)->getBoolOrThrowIfNull();
    }

    public function getIsForSale(): bool
    {
        return ToBool::fromIntOrNull($this->is_for_sale)->getBoolOrThrowIfNull();
    }

    public function getBarcode(): string
    {
        return ToString::fromStringOrNull($this->barcode)->getStringEvenIfNullGiven();
    }

    public function getCreateDateAsDateTime(): ?DateTime
    {
        return ToDateTime::fromOnlyDateString($this->create_date)->getDateTimeOrThrow();
    }

    public function getDescription(): string
    {
        return ToString::fromStringOrNull($this->description)->getStringEvenIfNullGiven();
    }

    public function getPrimeCost(): float|null
    {
        return ToFloat::fromStringOrNull($this->prime_cost)->getNonZeroFloatOrNull();
    }

    public function getCategoryId(): ?int
    {
        return (ToInt::fromIntOrStringOrNull($this->category_id))->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function setGroupId(?int $value): static
    {
        return self::setPropertyFluently($this, 'group_id', $value);
    }

    public function setTitle(?string $value): static
    {
        return self::setPropertyFluently($this, 'title', $value);
    }

    public function setUnitStorageId(?int $value): static
    {
        return self::setPropertyFluently($this, 'unit_storage_id', $value);
    }

    public function setIsWarehouseAccount(?bool $value): static
    {
        return self::setPropertyFluently($this, 'is_warehouse_account', is_null($value) ? null : (int)$value);
    }

    public function setIsActive(?bool $value): static
    {
        return self::setPropertyFluently($this, 'is_active', is_null($value) ? null : (int)$value);
    }

    public function setCode(?string $value): static
    {
        return self::setPropertyFluently($this, 'code', $value);
    }

    public function setIsCall(?bool $value): static
    {
        return self::setPropertyFluently($this, 'is_call', is_null($value) ? null : (int)$value);
    }

    public function setIsForSale(?bool $value): static
    {
        return self::setPropertyFluently($this, 'is_for_sale', is_null($value) ? null : (int)$value);
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
        return self::setPropertyFluently($this, 'category_id', $value);
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
