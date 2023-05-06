<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\ActiveRecord\Trait\BasicDAOTrait;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\Enum\ApiRoute;
use VetmanagerApiGateway\DTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

final class GoodSaleParam extends AbstractActiveRecord implements AllGetRequestsInterface
{
    use BasicDAOTrait;
    use AllGetRequestsTrait;

    /** Предзагружен. Нового АПИ запроса не будет */
    public DTO\GoodDto $good;

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

        $this->good = DTO\GoodDto::fromSingleObjectContents($this->apiGateway, $originalData['good']);
    }

    /** @return ApiRoute::GoodSaleParam */
    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::GoodSaleParam;
    }
}
