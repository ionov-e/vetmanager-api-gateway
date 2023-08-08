<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\InvoiceDocument;

use VetmanagerApiGateway\ApiDataInterpreter\ToFloat;

class InvoiceDocumentOnlyDto extends AbstractInvoiceDocumentOnlyDto
{
    public function __construct(
        protected ?string $id,
        protected ?string $document_id,
        protected ?string $good_id,
        protected ?string $quantity,
        protected ?string $price,
        protected ?string $responsible_user_id,
        protected ?string $is_default_responsible,
        protected ?string $sale_param_id,
        protected ?string $tag_id,
        protected ?string $discount_type,
        protected ?string $discount_document_id,
        protected ?string $discount_percent,
        protected ?string $default_price,
        protected ?string $create_date,
        protected ?string $discount_cause,
        protected ?string $fixed_discount_id,
        protected ?string $fixed_discount_percent,
        protected ?string $fixed_increase_id,
        protected ?string $fixed_increase_percent,
        protected ?string $prime_cost
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
        return self::setPropertyFluently($this, 'quantity', is_null($value) ? null : (string)$value);
    }

    public function setPrice(?float $value): static
    {
        return self::setPropertyFluently($this, 'price', is_null($value) ? null : (string)$value);
    }

//    /** @param array{
//     *     id: numeric-string,
//     *     document_id: string,
//     *     good_id: string,
//     *     quantity: ?int|numeric-string,
//     *     price: numeric|numeric-string,
//     *     responsible_user_id: string,
//     *     is_default_responsible: string,
//     *     sale_param_id: string,
//     *     tag_id: string,
//     *     discount_type: ?string,
//     *     discount_document_id: ?string,
//     *     discount_percent: ?string,
//     *     default_price: ?string,
//     *     create_date: string,
//     *     discount_cause: ?string,
//     *     fixed_discount_id: string,
//     *     fixed_discount_percent: string,
//     *     fixed_increase_id: string,
//     *     fixed_increase_percent: string,
//     *     prime_cost: string,
//     *     goodSaleParam?: array,
//     *     document?: array,
//     *     good?: array,
//     *     party_info?: array,
//     *     min_price?: float,
//     *     max_price?: float,
//     *     min_price_percent?: float,
//     *     max_price_percent?: float
//     * } $originalDataArray
//     */

}
