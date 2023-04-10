<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO\DTO\DAO;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\DTO;
use VetmanagerApiGateway\DO\DTO\DAO\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\DO\DTO\DAO\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\DO\DTO\DAO\Trait\BasicDAOTrait;
use VetmanagerApiGateway\DO\Enum\ApiRoute;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class GoodSaleParam extends DTO\GoodSaleParam implements AllGetRequestsInterface
{
    use BasicDAOTrait, AllGetRequestsTrait;

    /** Предзагружен. Нового АПИ запроса не будет */
    public DTO\Good $good;

    /** @var array{
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
     *     "unitSale": array{
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
     */
    protected readonly array $originalData;

    /** @throws VetmanagerApiGatewayException */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->good = DTO\Good::fromSingleObjectContents($this->apiGateway, $this->originalData['good']);
    }

    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::GoodSaleParam;
    }
}
