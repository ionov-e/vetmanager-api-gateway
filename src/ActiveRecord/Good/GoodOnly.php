<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Good;

use DateTime;
use VetmanagerApiGateway\ActiveRecord\GoodGroup\GoodGroup;
use VetmanagerApiGateway\ActiveRecord\GoodSaleParam\GoodSaleParamOnly;
use VetmanagerApiGateway\ActiveRecord\Unit\Unit;
use VetmanagerApiGateway\DTO\Good\GoodOnlyDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade;

/**
 * @property-read GoodOnlyDto $originalDto
 * @property positive-int $id
 * @property ?positive-int $groupId
 * @property string $title
 * @property ?positive-int $unitStorageId
 * @property bool $isWarehouseAccount Default in DB: True
 * @property bool $isActive Default in DB: True
 * @property string $code
 * @property bool $isCall Default in DB: False
 * @property bool $isForSale Default in DB: True
 * @property string $barcode
 * @property ?DateTime $createDate
 * @property string $description
 * @property float $primeCost Default in DB: '0.0000000000'
 * @property ?positive-int $categoryId
 * @property-read array{
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
 *     group: array{
 *              id: string,
 *              title: string,
 *              is_service: string,
 *              markup: ?string,
 *              is_show_in_vaccines: string,
 *              price_id: ?string
 *     },
 *     unitStorage?: array{
 *              id: string,
 *              title: string,
 *              status: string
 *     },
 *     goodSaleParams: list<array{
 *              id: numeric-string,
 *              good_id: numeric-string,
 *              price: ?string,
 *              coefficient: string,
 *              unit_sale_id: numeric-string,
 *              min_price: ?string,
 *              max_price: ?string,
 *              barcode: ?string,
 *              status: string,
 *              clinic_id: numeric-string,
 *              markup: string,
 *              price_formation: ?string,
 *              unitSale?: array{
 *                      id: string,
 *                      title: string,
 *                      status: string
 *              }
 *     }>
 * } $originalDataArray
 * @property-read GoodGroup $group
 * @property-read ?Unit $unit
 * @property-read GoodSaleParamOnly[] $goodSaleParams
 */
final class GoodOnly extends AbstractGood
{
    public static function getDtoClass(): string
    {
        return GoodOnlyDto::class;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getGoodGroup(): ?GoodGroup
    {
        return $this->getGroupId() ?
            (new Facade\GoodGroup($this->activeRecordFactory))->getById($this->getGroupId())
            : null;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getUnit(): ?Unit
    {
        return $this->getUnitId() ?
            (new Facade\Unit($this->activeRecordFactory))->getById($this->getUnitId())
            : null;
    }

    /** @inheritDoc
     * @throws VetmanagerApiGatewayException
     */
    public function getGoodSaleParams(): array
    {
        return (new Facade\Good($this->activeRecordFactory))->getById($this->getId())->getGoodSaleParams();
    }
}
