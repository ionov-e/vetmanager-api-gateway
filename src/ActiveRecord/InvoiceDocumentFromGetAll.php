<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Interface\RequestGetAllInterface;
use VetmanagerApiGateway\ActiveRecord\Interface\RequestGetByQueryInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\RequestGetAllTrait;
use VetmanagerApiGateway\ActiveRecord\Trait\RequestGetByQuery;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO\GoodDto;
use VetmanagerApiGateway\DTO\GoodSaleParamDto;
use VetmanagerApiGateway\DTO\InvoiceDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

final class InvoiceDocumentFromGetAll extends AbstractActiveRecord implements RequestGetAllInterface, RequestGetByQueryInterface
{

    use RequestGetAllTrait;
    use RequestGetByQuery;

    public InvoiceDto $invoice;
    public GoodDto $good;
    public GoodSaleParamDto $goodSaleParam;

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

        $this->goodSaleParam = GoodSaleParamDto::fromSingleObjectContents($this->apiGateway, $originalData['goodSaleParam']);
        $this->invoice = InvoiceDto::fromSingleObjectContents($this->apiGateway, $originalData['document']);
        $this->good = GoodDto::fromSingleObjectContents($this->apiGateway, $originalData['good']);
    }

    /** @return ApiModel::InvoiceDocument */
    public static function getApiModel(): ApiModel
    {
        return ApiModel::InvoiceDocument;
    }

    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            default => $this->$name,
        };
    }
}
