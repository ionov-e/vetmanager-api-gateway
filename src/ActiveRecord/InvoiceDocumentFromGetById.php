<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Interface\RequestGetByIdInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\RequestGetByIdTrait;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\FloatContainer;
use VetmanagerApiGateway\DTO;
use VetmanagerApiGateway\DTO\GoodDto;
use VetmanagerApiGateway\DTO\GoodSaleParamDto;
use VetmanagerApiGateway\DTO\InvoiceDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

final class InvoiceDocumentFromGetById extends AbstractActiveRecord implements RequestGetByIdInterface
{

    use RequestGetByIdTrait;

    /** Приходит сейчас int, но поручиться, что float не стоит исключать (странная функция округления)*/
    public float $minPrice;
    /** Приходит сейчас int, но поручиться, что float не стоит исключать (странная функция округления)*/
    public float $maxPrice;
    /** Приходит сейчас int, но поручиться, что float не стоит исключать (странная функция округления)*/
    public float $minPriceInPercents;
    /** Приходит сейчас int, но поручиться, что float не стоит исключать (странная функция округления)*/
    public float $maxPriceInPercents;
    /** Не нашел примеров. Только пустой массив мне всегда приходил. Судя по всему будет такой ответ #TODO find out expected response
     * @var array<int, array{
     *           "party_id": string,
     *           "party_exec_date": string,
     *           "store_id": string,
     *           "good_id": string,
     *           "characteristic_id": string,
     *           "quantity": ?string,
     *           "price": ?string
     *           }> $partyInfo
     */
    public array $partyInfo;
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
     *     },
     *     "party_info": array,
     *     "min_price": float,
     *     "max_price": float,
     *     "min_price_percent": float,
     *     "max_price_percent": float
     * } $originalData
     * @throws VetmanagerApiGatewayException
     * @psalm-suppress RedundantCastGivenDocblockType
     */
    public function __construct(ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->goodSaleParam = GoodSaleParamDto::fromSingleObjectContents($this->apiGateway, $originalData['goodSaleParam']);
        $this->invoice = InvoiceDto::fromSingleObjectContents($this->apiGateway, $originalData['document']);
        $this->good = GoodDto::fromSingleObjectContents($this->apiGateway, $originalData['good']);

        $this->minPrice = FloatContainer::fromStringOrNull((string)$originalData['min_price'])->float;
        $this->maxPrice = FloatContainer::fromStringOrNull((string)$originalData['max_price'])->float;
        $this->minPriceInPercents = FloatContainer::fromStringOrNull((string)$originalData['min_price_percent'])->float;
        $this->maxPriceInPercents = FloatContainer::fromStringOrNull((string)$originalData['max_price_percent'])->float;
        $this->partyInfo = (array)$originalData['party_info'];
    }

    /** @return ApiModel::InvoiceDocument */
    public static function getApiModel(): ApiModel
    {
        return ApiModel::InvoiceDocument;
    }

    public function __get(string $name): mixed
    {
        return match ($name) {
            default => $this->originalDto->$name
        };
    }
}
