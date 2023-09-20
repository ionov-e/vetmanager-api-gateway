<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\InvoiceDocument;

use VetmanagerApiGateway\ApiDataInterpreter\ToFloat;
use VetmanagerApiGateway\DTO\Good\GoodOnlyDto;
use VetmanagerApiGateway\DTO\GoodSaleParam\GoodSaleParamOnlyDto;
use VetmanagerApiGateway\DTO\Invoice\InvoiceOnlyDto;

class InvoiceDocumentPlusGoodSaleParamAndUnitAndInvoiceAndGoodDto extends AbstractInvoiceDocumentOnlyDto
{
    /**
     * @param int|null $id
     * @param int|null $document_id
     * @param int|null $good_id
     * @param int|null $quantity
     * @param int|null $price
     * @param int|null $responsible_user_id
     * @param int|null $is_default_responsible
     * @param int|null $sale_param_id
     * @param int|null $tag_id
     * @param string|null $discount_type
     * @param int|null $discount_document_id
     * @param string|null $discount_percent
     * @param string|null $default_price
     * @param string|null $create_date
     * @param string|null $discount_cause
     * @param int|null $fixed_discount_id
     * @param int|null $fixed_discount_percent
     * @param int|null $fixed_increase_id
     * @param int|null $fixed_increase_percent
     * @param string|null $prime_cost
     * @param InvoiceOnlyDto $document
     * @param GoodOnlyDto $good
     * @param GoodSaleParamOnlyDto $goodSaleParam
     */
    public function __construct(
        protected ?int           $id,
        protected ?int           $document_id,
        protected ?int           $good_id,
        protected ?int           $quantity,
        protected ?int           $price,
        protected ?int                 $responsible_user_id,
        protected ?int                 $is_default_responsible,
        protected ?int                 $sale_param_id,
        protected ?int                 $tag_id,
        protected ?string              $discount_type,
        protected ?int                 $discount_document_id,
        protected ?string              $discount_percent,
        protected ?string              $default_price,
        protected ?string              $create_date,
        protected ?string              $discount_cause,
        protected ?int                 $fixed_discount_id,
        protected ?int                 $fixed_discount_percent,
        protected ?int                 $fixed_increase_id,
        protected ?int                 $fixed_increase_percent,
        protected ?string              $prime_cost,
        protected InvoiceOnlyDto       $document,
        protected GoodOnlyDto          $good,
        protected GoodSaleParamOnlyDto $goodSaleParam
    )
    {
        parent::__construct(
            $id,
            $document_id,
            $good_id,
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
            $prime_cost
        );
    }

    public function getQuantity(): ?float
    {
        return ToFloat::fromStringOrNull((string)$this->quantity)->getNonZeroFloatOrNull();
    }

    public function getPrice(): float
    {
        return ToFloat::fromStringOrNull((string)$this->price)->getNonZeroFloatOrNull();
    }

    public function setQuantity(?float $value): static
    {
        return self::setPropertyFluently($this, 'quantity', $value);
    }

    public function setPrice(?float $value): static
    {
        return self::setPropertyFluently($this, 'price', $value);
    }

    public function getInvoiceOnlyDto(): InvoiceOnlyDto
    {
        return $this->document;
    }

    public function getGoodOnlyDto(): GoodOnlyDto
    {
        return $this->good;
    }

    public function getGoodSaleParamOnlyDto(): GoodSaleParamOnlyDto
    {
        return $this->goodSaleParam;
    }
}
