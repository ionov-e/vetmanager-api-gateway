<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\InvoiceDocument;

use DateTime;
use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\DTO\Good\GoodOnlyDto;
use VetmanagerApiGateway\DTO\GoodSaleParam\GoodSaleParamOnlyDto;
use VetmanagerApiGateway\DTO\Invoice\InvoiceOnlyDto;
use VetmanagerApiGateway\DTO\InvoiceDocument\DiscountTypeEnum;
use VetmanagerApiGateway\DTO\InvoiceDocument\InvoiceDocumentOnlyDto;

/**
 * @property-read InvoiceDocumentOnlyDto $originalDto
 * @property positive-int $id
 * @property positive-int $invoiceId
 * @property positive-int $goodId
 * @property ?float $quantity
 * @property float $price
 * @property ?positive-int $responsibleUserId
 * @property bool $isDefaultResponsible
 * @property positive-int $saleParamId Не видел без ID
 * @property ?positive-int $tagId
 * @property ?DiscountTypeEnum $discountType
 * @property ?positive-int $discountDocumentId
 * @property ?float $discountPercent
 * @property float $defaultPrice
 * @property DateTime $createDate
 * @property string $discountCause
 * @property ?positive-int $fixedDiscountId
 * @property ?positive-int $fixedDiscountPercent
 * @property ?positive-int $fixedIncreaseId
 * @property ?positive-int $fixedIncreasePercent
 * @property float $primeCost
 * @property-read array{
 *     id: numeric-string,
 *     document_id: string,
 *     good_id: string,
 *     quantity: ?int|numeric-string,
 *     price: numeric|numeric-string,
 *     responsible_user_id: string,
 *     is_default_responsible: string,
 *     sale_param_id: string,
 *     tag_id: string,
 *     discount_type: ?string,
 *     discount_document_id: ?string,
 *     discount_percent: ?string,
 *     default_price: ?string,
 *     create_date: string,
 *     discount_cause: ?string,
 *     fixed_discount_id: string,
 *     fixed_discount_percent: string,
 *     fixed_increase_id: string,
 *     fixed_increase_percent: string,
 *     prime_cost: string,
 *     goodSaleParam: array{
 *              id: string,
 *              good_id: string,
 *              price: ?string,
 *              coefficient: string,
 *              unit_sale_id: string,
 *              min_price: ?string,
 *              max_price: ?string,
 *              barcode: ?string,
 *              status: string,
 *              clinic_id: string,
 *              markup: string,
 *              price_formation: ?string,
 *              unitSale: array{
 *                       id: string,
 *                       title: string,
 *                       status: string
 *              }
 *     },
 *     document: array{
 *              id: string,
 *              doctor_id: ?string,
 *              client_id: string,
 *              pet_id: string,
 *              description: string,
 *              percent: ?string,
 *              amount: ?string,
 *              status: string,
 *              invoice_date: string,
 *              old_id: ?string,
 *              night: string,
 *              increase: ?string,
 *              discount: ?string,
 *              call: string,
 *              paid_amount: string,
 *              create_date: string,
 *              payment_status: string,
 *              clinic_id: string,
 *              creator_id: ?string,
 *              fiscal_section_id: string
 *     },
 *     good: array{
 *              id: string,
 *              group_id: string,
 *              title: string,
 *              unit_storage_id: string,
 *              is_warehouse_account: string,
 *              is_active: string,
 *              code: string,
 *              is_call: string,
 *              is_for_sale: string,
 *              barcode: string,
 *              create_date: string,
 *              description: string,
 *              prime_cost: string,
 *              category_id: ?string
 *     },
 *     party_info: array,
 *     min_price: float,
 *     max_price: float,
 *     min_price_percent: float,
 *     max_price_percent: float
 * } $originalDataArray "party_info", "min_price", "max_price", "min_price_percent", "max_price_percent" Только по ID
 * @property-read InvoiceOnlyDto $invoice
 * @property-read GoodOnlyDto $good
 * @property-read GoodSaleParamOnlyDto $goodSaleParam
 * @property-read float $minPrice Приходит сейчас int, но поручиться, что float не стоит исключать (странная функция округления)
 * @property-read float $maxPrice Приходит сейчас int, но поручиться, что float не стоит исключать (странная функция округления)
 * @property-read float $minPriceInPercents Приходит сейчас int, но поручиться, что float не стоит исключать (странная функция округления)
 * @property-read float $maxPriceInPercents Приходит сейчас int, но поручиться, что float не стоит исключать (странная функция округления)
 * @property-read list<array{
 *                           party_id: string,
 *                           party_exec_date: string,
 *                           store_id: string,
 *                           good_id: string,
 *                           characteristic_id: string,
 *                           quantity: ?string,
 *                           price: ?string
 *           }> $partyInfo Не нашел примеров. Только пустой массив мне всегда приходил. Судя по всему будет такой ответ #TODO find out expected response
 */
abstract class AbstractInvoiceDocument extends AbstractActiveRecord
{
    public static function getRouteKey(): string
    {
        return 'invoiceDocument';
    }

//    /** @throws VetmanagerApiGatewayException */
//    public function __get(string $name): mixed
//    {
//        switch ($name) {
//            case 'minPrice':
//            case 'maxPrice':
//            case 'minPriceInPercents':
//            case 'maxPriceInPercents':
//            case 'partyInfo':
//                $this->fillCurrentObjectWithGetByIdDataIfSourceIsNotFull();
//        }
//
//        return match ($name) {
//            'minPrice' => ToFloat::fromStringOrNull((string)$this->originalDataArray['min_price'])->getNonZeroFloatOrNull(),
//            'maxPrice' => ToFloat::fromStringOrNull((string)$this->originalDataArray['max_price'])->getNonZeroFloatOrNull(),
//            'minPriceInPercents' => ToFloat::fromStringOrNull((string)$this->originalDataArray['min_price_percent'])->getNonZeroFloatOrNull(),
//            'maxPriceInPercents' => ToFloat::fromStringOrNull((string)$this->originalDataArray['max_price_percent'])->getNonZeroFloatOrNull(),
//            'partyInfo' => $this->originalDataArray['party_info'],
//            'good' => ($this->completenessLevel == Completeness::OnlyBasicDto)
//                ? Good::getById($this->activeRecordFactory, $this->goodId)
//                : Good::fromSingleDtoArrayUsingBasicDto($this->activeRecordFactory, $this->originalDataArray['good']),
//            'goodSaleParam' => ($this->completenessLevel == Completeness::OnlyBasicDto)
//                ? GoodSaleParam::getById($this->activeRecordFactory, $this->saleParamId)
//                : GoodSaleParam::fromSingleDtoArrayAsFromGetById($this->activeRecordFactory, $this->getArrayFromFullActiveRecordForGoodSaleParam()),
//            'invoice' => ($this->completenessLevel == Completeness::OnlyBasicDto)
//                ? Invoice::getById($this->activeRecordFactory, $this->invoiceId)
//                : Invoice::fromSingleDtoArrayUsingBasicDto($this->activeRecordFactory, $this->originalDataArray['document']),
//            default => $this->originalDto->$name
//        };
//    }
//
//    private function getArrayFromFullActiveRecordForGoodSaleParam(): array
//    {
//        return array_merge(
//            $this->originalDataArray['goodSaleParam'],
//            ['good' => $this->originalDataArray['good']]
//        );
//    }
}
