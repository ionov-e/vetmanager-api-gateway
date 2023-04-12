<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO\DTO\DAO;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\DTO;
use VetmanagerApiGateway\DO\DTO\DAO;
use VetmanagerApiGateway\DO\DTO\DAO\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\DO\DTO\DAO\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\DO\DTO\DAO\Trait\BasicDAOTrait;
use VetmanagerApiGateway\DO\Enum\ApiRoute;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

final class Good extends DTO\Good implements AllGetRequestsInterface
{
    use BasicDAOTrait;
    use AllGetRequestsTrait;

    /** Предзагружен. Нового АПИ запроса не будет */
    public DAO\GoodGroup $group;
    /** Предзагружен. Нового АПИ запроса не будет */
    public ?DAO\Unit $unit;
    /** @var GoodSaleParam[] Предзагружены. Нового АПИ запроса не будет */
    public array $goodSaleParams;

    /** @var array{
     *     "id": string,
     *     "group_id": ?string,
     *     "title": string,
     *     "unit_storage_id": ?string,
     *     "is_warehouse_account": string,
     *     "is_active": string,
     *     "code": ?string,
     *     "is_call": string,
     *     "is_for_sale": string,
     *     "barcode": ?string,
     *     "create_date": string,
     *     "description": string,
     *     "prime_cost": string,
     *     "category_id": ?string,
     *     "group": array{
     *              "id": string,
     *              "title": string,
     *              "is_service": string,
     *              "markup": ?string,
     *              "is_show_in_vaccines": string,
     *              "price_id": ?string
     *     },
     *     ?"unitStorage": array{
     *              "id": string,
     *              "title": string,
     *              "status": string
     *     },
     *     "goodSaleParams": array<int, array{
     *              "id": string,
     *              "good_id": string,
     *              "price": ?string,
     *              "coefficient": string,
     *              "unit_sale_id": string,
     *              "min_price": ?string,
     *              "max_price": ?string,
     *              "barcode": ?string,
     *              "status": string,
     *              "clinic_id": string,
     *              "markup": string,
     *              "price_formation": ?string,
     *              ?"unitSale": array{
     *                      "id": string,
     *                      "title": string,
     *                      "status": string,
     *              }
     *     }
     * } $originalData
     */
    protected readonly array $originalData;

    /** @throws VetmanagerApiGatewayException */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->group = DAO\GoodGroup::fromSingleObjectContents($this->apiGateway, $this->originalData['group']);

        $this->unit = !empty($this->originalData['unitStorage'])
            ? DAO\Unit::fromSingleObjectContents($this->apiGateway, $this->originalData['unitStorage'])
            : null;

        $this->goodSaleParams = DAO\GoodSaleParam::fromMultipleObjectsContents(
            $this->apiGateway,
            $this->getContentsForGoodSaleParamDAOs()
        );
    }

    private function getContentsForGoodSaleParamDAOs(): array
    {
        return array_map(
            fn (array $goodSaleParamObject): array => array_merge(
                $goodSaleParamObject,
                !empty($this->originalData['unitStorage']) ? ['unitSale' => $this->originalData['unitStorage']] : [],
                ['good' => $this->getOnlyGoodContentsArray()]
            ),
            $this->originalData['goodSaleParams']
        );
    }

    /** @return array<string, ?string> */
    private function getOnlyGoodContentsArray(): array
    {
        $originalData = $this->originalData;
        unset($originalData['group'], $originalData['unitStorage'], $originalData['goodSaleParams']);
        return $originalData;
    }

    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::Good;
    }
}
