<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\InvoiceDocument;

use VetmanagerApiGateway\DTO\Good\GoodOnlyDto;
use VetmanagerApiGateway\DTO\GoodSaleParam\GoodSaleParamOnlyDto;
use VetmanagerApiGateway\DTO\Invoice\InvoiceOnlyDto;

class InvoiceDocumentPlusGoodSaleParamAndUnitAndInvoiceAndGoodWithPartyInfoAndMinMaxDto extends InvoiceDocumentPlusGoodSaleParamAndUnitAndInvoiceAndGoodDto
{
    /**
     * @param string|null $id
     * @param string|null $document_id
     * @param string|null $good_id
     * @param int|null $quantity
     * @param int|null $price
     * @param string|null $responsible_user_id
     * @param string|null $is_default_responsible
     * @param string|null $sale_param_id
     * @param string|null $tag_id
     * @param string|null $discount_type
     * @param string|null $discount_document_id
     * @param string|null $discount_percent
     * @param string|null $default_price
     * @param string|null $create_date
     * @param string|null $discount_cause
     * @param string|null $fixed_discount_id
     * @param string|null $fixed_discount_percent
     * @param string|null $fixed_increase_id
     * @param string|null $fixed_increase_percent
     * @param string|null $prime_cost
     * @param InvoiceOnlyDto $document
     * @param GoodOnlyDto $good
     * @param GoodSaleParamOnlyDto $goodSaleParam
     * @param array $party_info
     * @param float $min_price
     * @param float $max_price
     * @param float $min_price_percent
     * @param float $max_price_percent
     */
    public function __construct(
        protected ?string              $id,
        protected ?string              $document_id,
        protected ?string              $good_id,
        protected ?int                 $quantity,
        protected ?int                 $price,
        protected ?string              $responsible_user_id,
        protected ?string              $is_default_responsible,
        protected ?string              $sale_param_id,
        protected ?string              $tag_id,
        protected ?string              $discount_type,
        protected ?string              $discount_document_id,
        protected ?string              $discount_percent,
        protected ?string              $default_price,
        protected ?string              $create_date,
        protected ?string              $discount_cause,
        protected ?string              $fixed_discount_id,
        protected ?string              $fixed_discount_percent,
        protected ?string              $fixed_increase_id,
        protected ?string              $fixed_increase_percent,
        protected ?string              $prime_cost,
        protected InvoiceOnlyDto       $document,
        protected GoodOnlyDto          $good,
        protected GoodSaleParamOnlyDto $goodSaleParam,
        protected array                $party_info,
        protected float                $min_price,
        protected float                $max_price,
        protected float                $min_price_percent,
        protected float                $max_price_percent
    )
    {
        parent::__construct(
            $id,
            $document_id,
            $good_id,
            $quantity,
            $price,
            $responsible_user_id,
            $is_default_responsible,
            $sale_param_id,
            $tag_id,
            $discount_type,
            $discount_document_id,
            $discount_percent,
            $default_price,
            $create_date,
            $discount_cause,
            $fixed_discount_id,
            $fixed_discount_percent,
            $fixed_increase_id,
            $fixed_increase_percent,
            $prime_cost,
            $document,
            $good,
            $goodSaleParam
        );
    }

    /** Так и ни разу не увидел, чтобы приходило что-то */
    public function getPartyInfo(): array
    {
        return $this->party_info;
    }

    public function getMinPrice(): float
    {
        return $this->min_price;
    }

    public function getMaxPrice(): float
    {
        return $this->max_price;
    }

    /** Возможно только целые числа могут приходить */
    public function getMinPriceInPercents(): float
    {
        return $this->min_price_percent;
    }

    /** Возможно только целые числа могут приходить */
    public function getMaxPriceInPercents(): float
    {
        return $this->max_price_percent;
    }
}
