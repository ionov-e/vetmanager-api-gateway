<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\GoodSaleParam;

use VetmanagerApiGateway\ActiveRecord\Good\GoodOnly;
use VetmanagerApiGateway\ActiveRecord\Unit\Unit;
use VetmanagerApiGateway\DTO\GoodSaleParam\GoodSaleParamOnlyDto;
use VetmanagerApiGateway\DTO\GoodSaleParam\GoodSaleParamPlusUnitAndGoodDto;
use VetmanagerApiGateway\DTO\GoodSaleParam\PriceFormationEnum;
use VetmanagerApiGateway\DTO\GoodSaleParam\StatusEnum;

/**
 * @property-read GoodSaleParamOnlyDto $originalDto
 * @property positive-int id
 * @property ?positive-int goodId
 * @property ?float price
 * @property float coefficient
 * @property ?positive-int unitSaleId
 * @property ?float minPriceInPercents
 * @property ?float maxPriceInPercents
 * @property string barcode
 * @property StatusEnum status Default: 'active'
 * @property ?positive-int clinicId
 * @property ?float markup
 * @property PriceFormationEnum priceFormation
 * @property-read array{
 *     id: string,
 *     good_id: string,
 *     price: ?string,
 *     coefficient: string,
 *     unit_sale_id: string,
 *     min_price: ?string,
 *     max_price: ?string,
 *     barcode: ?string,
 *     status: string,
 *     clinic_id: string,
 *     markup: string,
 *     price_formation: ?string,
 *     unitSale?: array{
 *             id: string,
 *             title: string,
 *             status: string
 *     },
 *     good: array{
 *              id: string,
 *              group_id: ?string,
 *              title: string,
 *              unit_storage_id: ?string,
 *              is_warehouse_account: string,
 *              is_active: string,
 *              code: ?string,
 *              is_call: string,
 *              is_for_sale: string,
 *              barcode: ?string,
 *              create_date: string,
 *              description: string,
 *              prime_cost: string,
 *              category_id: ?string
 *     }
 * } $originalDataArray 'unitSale' и 'good' присутствуют и при GetById и GetAll
 * @property-read ?Unit $unit
 * @property-read GoodOnly $good
 */
final class GoodSaleParamPlusUnitAndGood extends AbstractGoodSaleParam
{
    public static function getDtoClass(): string
    {
        return GoodSaleParamPlusUnitAndGoodDto::class;
    }
}
