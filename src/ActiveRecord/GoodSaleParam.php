<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

final class GoodSaleParam extends AbstractActiveRecord implements AllGetRequestsInterface
{

    use AllGetRequestsTrait;

    /** Предзагружен. Нового АПИ запроса не будет */
    public Good $good;
    /** Предзагружен. Нового АПИ запроса не будет */
    public ?Unit $unit;

    /** @param array{
     *     "id": string,
     *     "good_id": string,
     *     "price": ?string,
     *     "coefficient": string,
     *     "unit_sale_id": string,
     *     "min_price": ?string,
     *     "max_price": ?string,
     *     "barcode": ?string,
     *     "status": string,
     *     "clinic_id": string,
     *     "markup": string,
     *     "price_formation": ?string,
     *     "unitSale"?: array{
     *             "id": string,
     *             "title": string,
     *             "status": string,
     *     },
     *     "good": array{
     *              "id": string,
     *              "group_id": ?string,
     *              "title": string,
     *              "unit_storage_id": ?string,
     *              "is_warehouse_account": string,
     *              "is_active": string,
     *              "code": ?string,
     *              "is_call": string,
     *              "is_for_sale": string,
     *              "barcode": ?string,
     *              "create_date": string,
     *              "description": string,
     *              "prime_cost": string,
     *              "category_id": ?string,
     *     }
     * } $originalData
     * @throws VetmanagerApiGatewayException
     */
    public function __construct(ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->unit = !empty($originalData['unitSale'])     #TODO Move
            ? Unit::fromSingleObjectContents($this->apiGateway, $originalData['unitSale'])
            : null;
        $this->good = Good::fromSingleObjectContents($this->apiGateway, $originalData['good']); #TODO this was DTO
    }

    /** @return ApiModel::GoodSaleParam */
    public static function getApiModel(): ApiModel
    {
        return ApiModel::GoodSaleParam;
    }


    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            default => $this->$name,
        };
    }
}
