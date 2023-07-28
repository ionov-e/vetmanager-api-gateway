<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Good;

use DateTime;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Hydrator\ApiBool;
use VetmanagerApiGateway\Hydrator\ApiDateTime;
use VetmanagerApiGateway\Hydrator\ApiFloat;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;
use VetmanagerApiGateway\Hydrator\DtoPropertyList;

class GoodOnlyDto extends AbstractDTO
{
    /** @var positive-int */
    public int $id;
    /** @var ?positive-int */
    public ?int $groupId;
    public string $title;
    /** @var ?positive-int */
    public ?int $unitStorageId;
    /** Default: 1 */
    public bool $isWarehouseAccount;
    /** Default: 1 */
    public bool $isActive;
    public string $code;
    /** Default: 0 */
    public bool $isCall;
    /** Default: 1 */
    public bool $isForSale;
    public string $barcode;
    public ?DateTime $createDate;
    public string $description;
    /** Default: '0.0000000000' */
    public float $primeCost;
    /** @var ?positive-int */
    public ?int $categoryId;

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
    public static function fromApiResponseArray(array $originalDataArray): self
    {
        $instance = new self($originalDataArray);
        $instance->id = ApiInt::fromStringOrNull($originalDataArray['id'])->getPositiveInt();
        $instance->groupId = ApiInt::fromStringOrNull($originalDataArray['group_id'])->getPositiveIntOrNull();
        $instance->title = ApiString::fromStringOrNull($originalDataArray['title'])->getStringEvenIfNullGiven();
        $instance->unitStorageId = ApiInt::fromStringOrNull($originalDataArray['unit_storage_id'])->getPositiveIntOrNull();
        $instance->isWarehouseAccount = ApiBool::fromStringOrNull($originalDataArray['is_warehouse_account'])->getBoolOrThrowIfNull();
        $instance->isActive = ApiBool::fromStringOrNull($originalDataArray['is_active'])->getBoolOrThrowIfNull();
        $instance->code = ApiString::fromStringOrNull($originalDataArray['code'])->getStringEvenIfNullGiven();
        $instance->isCall = ApiBool::fromStringOrNull($originalDataArray['is_call'])->getBoolOrThrowIfNull();
        $instance->isForSale = ApiBool::fromStringOrNull($originalDataArray['is_for_sale'])->getBoolOrThrowIfNull();
        $instance->barcode = ApiString::fromStringOrNull($originalDataArray['barcode'])->getStringEvenIfNullGiven();
        $instance->createDate = ApiDateTime::fromOnlyDateString($originalDataArray['create_date'])->getDateTimeOrThrow();
        $instance->description = ApiString::fromStringOrNull($originalDataArray['description'])->getStringEvenIfNullGiven();
        $instance->primeCost = ApiFloat::fromStringOrNull($originalDataArray['prime_cost'])->getNonZeroFloatOrNull();
        $instance->categoryId = ApiInt::fromStringOrNull($originalDataArray['category_id'])->getPositiveIntOrNull();
        return $instance;
    }

    /** @inheritdoc */
    public function getRequiredKeysForPostArray(): array #TODO No Idea
    {
        return [];
    }

    /** @inheritdoc
     * @throws VetmanagerApiGatewayRequestException
     */
    protected function getSetValuesWithoutId(): array
    {
        return (new DtoPropertyList(
            $this,
            ['groupId', 'group_id'],
            ['title', 'title'],
            ['unitStorageId', 'unit_storage_id'],
            ['isWarehouseAccount', 'is_warehouse_account'],
            ['isActive', 'is_active'],
            ['code', 'code'],
            ['isCall', 'is_call'],
            ['isForSale', 'is_for_sale'],
            ['barcode', 'barcode'],
            ['createDate', 'create_date'],
            ['description', 'description'],
            ['primeCost', 'prime_cost'],
            ['categoryId', 'category_id'],
        ))->toArray();
    }
}
