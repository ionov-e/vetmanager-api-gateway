<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Good;

use DateTime;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;
use VetmanagerApiGateway\Hydrator\ApiBool;
use VetmanagerApiGateway\Hydrator\ApiDateTime;
use VetmanagerApiGateway\Hydrator\ApiFloat;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;

class GoodOnlyDto extends AbstractDTO
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

    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int
    {
        return ApiInt::fromStringOrNull($this->id)->getPositiveInt();
    }

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */

    public function getGroupId(): ?int
    {
        return ApiInt::fromStringOrNull($this->group_id)->getPositiveIntOrNull();

    }

    public function getTitle(): string
    {
        return ApiString::fromStringOrNull($this->title)->getStringEvenIfNullGiven();
    }

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getUnitStorageId(): ?int
    {
        return ApiInt::fromStringOrNull($this->unit_storage_id)->getPositiveIntOrNull();
    }

    /** Default: 1
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getIsWarehouseAccount(): bool
    {
        return ApiBool::fromStringOrNull($this->is_warehouse_account)->getBoolOrThrowIfNull();
    }

    /** Default: 1
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getIsActive(): bool
    {
        return ApiBool::fromStringOrNull($this->is_active)->getBoolOrThrowIfNull();
    }

    public function getCode(): string
    {
        return ApiString::fromStringOrNull($this->code)->getStringEvenIfNullGiven();
    }

    /** Default: 0
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getIsCall(): bool
    {
        return ApiBool::fromStringOrNull($this->is_call)->getBoolOrThrowIfNull();
    }

    /** Default: 1
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getIsForSale(): bool
    {
        return ApiBool::fromStringOrNull($this->is_for_sale)->getBoolOrThrowIfNull();
    }

    public function getBarcode(): string
    {
        return ApiString::fromStringOrNull($this->barcode)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayResponseException */
    public function getCreateDate(): ?DateTime
    {
        return ApiDateTime::fromOnlyDateString($this->create_date)->getDateTimeOrThrow();
    }

    public function getDescription(): string
    {
        return ApiString::fromStringOrNull($this->description)->getStringEvenIfNullGiven();
    }

    /** Default: '0.0000000000'
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getPrimeCost(): float
    {
        return ApiFloat::fromStringOrNull($this->prime_cost)->getNonZeroFloatOrNull();
    }

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getCategoryId(): ?int
    {
        return ApiInt::fromStringOrNull($this->category_id)->getPositiveIntOrNull();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setId(?int $value): static
    {
        return self::setPropertyFluently($this, 'id', is_null($value) ? null : (string)$value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setGroupId(?int $value): static
    {
        return self::setPropertyFluently($this, 'group_id', is_null($value) ? null : (string)$value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTitle(?string $value): static
    {
        return self::setPropertyFluently($this, 'title', $value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setUnitStorageId(?int $value): static
    {
        return self::setPropertyFluently($this, 'unit_storage_id', is_null($value) ? null : (string)$value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setIsWarehouseAccount(?bool $value): static
    {
        return self::setPropertyFluently($this, 'is_warehouse_account', is_null($value) ? null : (string)(int)$value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setIsActive(?bool $value): static
    {
        return self::setPropertyFluently($this, 'is_active', is_null($value) ? null : (string)(int)$value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCode(?string $value): static
    {
        return self::setPropertyFluently($this, 'code', $value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setIsCall(?bool $value): static
    {
        return self::setPropertyFluently($this, 'is_call', is_null($value) ? null : (string)(int)$value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setIsForSale(?bool $value): static
    {
        return self::setPropertyFluently($this, 'is_for_sale', is_null($value) ? null : (string)(int)$value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setBarcode(?string $value): static
    {
        return self::setPropertyFluently($this, 'barcode', $value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCreateDateFromString(?string $value): static
    {
        return self::setPropertyFluently($this, 'create_date', $value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCreateDateFromDateTime(DateTime $value): static
    {
        return self::setPropertyFluently($this, 'create_date', $value->format('Y-m-d H:i:s'));
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDescription(?string $value): static
    {
        return self::setPropertyFluently($this, 'description', $value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setPrimeCost(?float $value): static
    {
        return self::setPropertyFluently($this, 'prime_cost', is_null($value) ? null : (string)$value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCategoryId(?int $value): static
    {
        return self::setPropertyFluently($this, 'category_id', is_null($value) ? null : (string)$value);
    }
    
    /** @param array{
     *     id: numeric-string,
     *     group_id: ?numeric-string,
     *     title: string,
     *     unit_storage_id: ?numeric-string,
     *     is_warehouse_account: string,
     *     is_active: string,
     *     code: ?string,
     *     is_call: string,
     *     is_for_sale: string,
     *     barcode: ?string,
     *     create_date: string,
     *     description: string,
     *     prime_cost: string,
     *     category_id: ?numeric-string,
     *     group?: array,
     *     unitStorage?: array,
     *     goodSaleParams?: array
     * } $originalDataArray
     * @throws VetmanagerApiGatewayException
     * @psalm-suppress MoreSpecificImplementedParamType
     */
}
