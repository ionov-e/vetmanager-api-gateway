<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\InvoiceDocument;

use VetmanagerApiGateway\ApiDataInterpreter\ToFloat;

class InvoiceDocumentOnlyDto extends AbstractInvoiceDocumentOnlyDto
{
    /**
     * @param int|null $id
     * @param int|null $document_id
     * @param int|null $good_id
     * @param string|null $quantity
     * @param string|null $price
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
     */
    public function __construct(
        protected ?int    $id,
        protected ?int    $document_id,
        protected ?int    $good_id,
        protected ?string $quantity,
        protected ?string $price,
        protected ?int    $responsible_user_id,
        protected ?int    $is_default_responsible,
        protected ?int    $sale_param_id,
        protected ?int    $tag_id,
        protected ?string $discount_type,
        protected ?int    $discount_document_id,
        protected ?string $discount_percent,
        protected ?string $default_price,
        protected ?string $create_date,
        protected ?string $discount_cause,
        protected ?int    $fixed_discount_id,
        protected ?int    $fixed_discount_percent,
        protected ?int    $fixed_increase_id,
        protected ?int    $fixed_increase_percent,
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
