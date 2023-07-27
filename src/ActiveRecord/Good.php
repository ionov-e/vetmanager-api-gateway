<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use DateTime;
use VetmanagerApiGateway\ActiveRecord\Enum\Completeness;
use VetmanagerApiGateway\DTO\GoodDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/**
 * @property-read GoodDto $originalDto
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
 * @property-read GoodSaleParam[] $goodSaleParams
 */
final class Good extends AbstractActiveRecord
{
    public static function getCompletenessFromGetAllOrByQuery(): Completeness
    {
        return Completeness::Full;
    }

    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        switch ($name) {
            case 'group':
            case 'unit':
            case 'goodSaleParams':
                $this->fillCurrentObjectWithGetByIdDataIfSourceIsFromBasicDto();
        }

        return match ($name) {
            'group' => GoodGroup::fromSingleDtoArrayAsFromGetById($this->activeRecordFactory, $this->originalDataArray['group']),
            'unit' => !empty($this->originalDataArray['unitStorage'])
                ? Unit::fromSingleDtoArrayAsFromGetById($this->activeRecordFactory, $this->originalDataArray['unitStorage'])
                : null,
            'goodSaleParams' => GoodSaleParam::fromMultipleDtosArrays(
                $this->activeRecordFactory,
                $this->getFullDataForGoodSaleParamActiveRecords(),
                Completeness::Full
            ),
            default => $this->originalDto->$name
        };
    }

    private function getFullDataForGoodSaleParamActiveRecords(): array
    {
        return array_map(
            fn (array $goodSaleParamObject): array => array_merge(
                $goodSaleParamObject,
                !empty($this->originalDataArray['unitStorage']) ? ['unitSale' => $this->originalDataArray['unitStorage']] : [],
                ['good' => $this->getOnlyGoodContentsArray()]
            ),
            $this->originalDataArray['goodSaleParams']
        );
    }

    /** @return array<string, ?string> */
    private function getOnlyGoodContentsArray(): array
    {
        $originalDataArray = $this->originalDataArray;
        unset($originalDataArray['group'], $originalDataArray['unitStorage'], $originalDataArray['goodSaleParams']);
        return $originalDataArray;
    }
}
