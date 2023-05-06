<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Interface\RequestGetAllInterface;
use VetmanagerApiGateway\ActiveRecord\Interface\RequestGetByQueryInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\BasicDAOTrait;
use VetmanagerApiGateway\ActiveRecord\Trait\RequestGetAllTrait;
use VetmanagerApiGateway\ActiveRecord\Trait\RequestGetByQuery;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\Enum\ApiRoute;
use VetmanagerApiGateway\DTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

final class InvoiceDocumentFromGetAll extends AbstractActiveRecord implements RequestGetAllInterface, RequestGetByQueryInterface
{
    use BasicDAOTrait;
    use RequestGetAllTrait;
    use RequestGetByQuery;

    public DTO\InvoiceDto $invoice;
    public DTO\GoodDto $good;

    /** @param array{
     *     "id": numeric-string,
     *     "document_id": string,
     *     "good_id": string,
     *     "quantity": ?int|numeric-string,
     *     "price": numeric|numeric-string,
     *     "responsible_user_id": string,
     *     "is_default_responsible": string,
     *     "sale_param_id": string,
     *     "tag_id": string,
     *     "discount_type": ?string,
     *     "discount_document_id": ?string,
     *     "discount_percent": ?string,
     *     "default_price": ?string,
     *     "create_date": string,
     *     "discount_cause": ?string,
     *     "fixed_discount_id": string,
     *     "fixed_discount_percent": string,
     *     "fixed_increase_id": string,
     *     "fixed_increase_percent": string,
     *     "prime_cost": string,
     *     "goodSaleParam": array{
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
     *              "unitSale": array{
     *                       "id": string,
     *                       "title": string,
     *                       "status": string
     *              }
     *     },
     *     "document": array{
     *              "id": string,
     *              "doctor_id": ?string,
     *              "client_id": string,
     *              "pet_id": string,
     *              "description": string,
     *              "percent": ?string,
     *              "amount": ?string,
     *              "status": string,
     *              "invoice_date": string,
     *              "old_id": ?string,
     *              "night": string,
     *              "increase": ?string,
     *              "discount": ?string,
     *              "call": string,
     *              "paid_amount": string,
     *              "create_date": string,
     *              "payment_status": string,
     *              "clinic_id": string,
     *              "creator_id": ?string,
     *              "fiscal_section_id": string,
     *     },
     *     "good": array{
     *              "id": string,
     *              "group_id": string,
     *              "title": string,
     *              "unit_storage_id": string,
     *              "is_warehouse_account": string,
     *              "is_active": string,
     *              "code": string,
     *              "is_call": string,
     *              "is_for_sale": string,
     *              "barcode": string,
     *              "create_date": string,
     *              "description": string,
     *              "prime_cost": string,
     *              "category_id": ?string
     *     }
     * } $originalData
     * @throws VetmanagerApiGatewayException
     */
    public function __construct(ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->invoice = DTO\InvoiceDto::fromSingleObjectContents($this->apiGateway, $originalData['document']);
        $this->good = DTO\GoodDto::fromSingleObjectContents($this->apiGateway, $originalData['good']);
    }

    /** @return ApiRoute::InvoiceDocument */
    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::InvoiceDocument;
    }
}
