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

class InvoiceDocument extends DTO\InvoiceDocument implements AllGetRequestsInterface
{
    use BasicDAOTrait;
    use AllGetRequestsTrait;

    /** Приходит сейчас int, но поручиться, что float не стоит исключать (странная функция округления)*/
    public ?float $minPrice;
    /** Приходит сейчас int, но поручиться, что float не стоит исключать (странная функция округления)*/
    public ?float $maxPrice;
    /** Приходит сейчас int, но поручиться, что float не стоит исключать (странная функция округления)*/
    public ?float $minPriceInPercents;
    /** Приходит сейчас int, но поручиться, что float не стоит исключать (странная функция округления)*/
    public ?float $maxPriceInPercents;
    public DTO\Invoice $invoice;
    public DTO\Good $good;
    /** @var array{
     *     "id": string,
     *     "document_id": string,
     *     "good_id": string,
     *     "quantity": ?int,
     *     "price": ?float,
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
     *     "party_info": array,
     *     "min_price": float,
     *     "max_price": float,
     *     "min_price_percent": float,
     *     "max_price_percent": float,
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
     *     },
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
     *     }
     * }
     */
    protected readonly array $originalData;

    /** @throws VetmanagerApiGatewayException */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->minPrice = (float)$this->originalData['min_price'];
        $this->maxPrice = (float)$this->originalData['max_price'];
        $this->minPriceInPercents = (float)$this->originalData['min_price_percent'];
        $this->maxPriceInPercents = (float)$this->originalData['max_price_percent'];

        $this->invoice = DTO\Invoice::fromSingleObjectContents($this->apiGateway, $this->originalData['document']);
        $this->good = DTO\Good::fromSingleObjectContents($this->apiGateway, $this->originalData['good']);
    }

    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::InvoiceDocument;
    }
}
