<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Enum\Completeness;
use VetmanagerApiGateway\ActiveRecord\Interface\AllRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllRequestsTrait;
use VetmanagerApiGateway\DTO\Enum\GoodSaleParam\PriceFormation;
use VetmanagerApiGateway\DTO\Enum\GoodSaleParam\Status;
use VetmanagerApiGateway\DTO\GoodSaleParamDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/**
 * @property-read GoodSaleParamDto $originalDto
 * @property positive-int id
 * @property ?positive-int goodId
 * @property ?float price
 * @property float coefficient
 * @property ?positive-int unitSaleId
 * @property ?float minPriceInPercents
 * @property ?float maxPriceInPercents
 * @property string barcode
 * @property Status status Default: 'active'
 * @property ?positive-int clinicId
 * @property ?float markup
 * @property PriceFormation priceFormation
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
 *             status: string,
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
 *              category_id: ?string,
 *     }
 * } $originalDataArray 'unitSale' и 'good' присутствуют и при GetById и GetAll
 */
final class GoodSaleParam extends AbstractActiveRecord implements AllRequestsInterface
{

    use AllRequestsTrait;

    /** @return ApiModel::GoodSaleParam */
    public static function getApiModel(): ApiModel
    {
        return ApiModel::GoodSaleParam;
    }

    public static function getCompletenessFromGetAllOrByQuery(): Completeness
    {
        return Completeness::Full;
    }

    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        switch ($name) {
            case 'unit':
            case 'good':
                $this->fillCurrentObjectWithGetByIdDataIfSourceIsFromBasicDto();
        }

        return match ($name) {
            'unit' => Unit::fromSingleDtoArrayUsingBasicDto($this->apiGateway, $this->originalDataArray['unitSale']),
            'good' => !empty($this->originalDataArray['good'])
                ? Good::fromSingleDtoArray($this->apiGateway, $this->originalDataArray['good'])
                : null,
            default => $this->originalDto->$name
        };
    }
}
