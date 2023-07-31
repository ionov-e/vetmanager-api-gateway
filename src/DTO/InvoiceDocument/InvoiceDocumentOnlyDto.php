<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\InvoiceDocument;

use DateTime;
use VetmanagerApiGateway\ApiDataInterpreter\ToBool;
use VetmanagerApiGateway\ApiDataInterpreter\ToDateTime;
use VetmanagerApiGateway\ApiDataInterpreter\ToFloat;
use VetmanagerApiGateway\ApiDataInterpreter\ToInt;
use VetmanagerApiGateway\ApiDataInterpreter\ToString;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class InvoiceDocumentOnlyDto extends AbstractDTO
{
    /** @var positive-int */
    public int $id;
    /** @var positive-int */
    public int $invoiceId;
    /** @var positive-int */
    public int $goodId;
    public ?float $quantity;
    public float $price;
    /** @var ?positive-int Default: '0' */
    public ?int $responsibleUserId;
    public bool $isDefaultResponsible;
    /** @var positive-int Default in BD: '0'. Но не видел 0 */
    public int $saleParamId;
    /** @var ?positive-int Default: '0' */
    public ?int $tagId;
    public ?DiscountTypeEnum $discountType;
    /** @var ?positive-int */
    public ?int $discountDocumentId;
    public ?float $discountPercent;
    /** Default: 0.00000000 */
    public float $defaultPrice;
    public DateTime $createDate;
    public string $discountCause;
    /** @var ?positive-int Default: '0' */
    public ?int $fixedDiscountId;
    /** @var ?positive-int Default: '0' */
    public ?int $fixedDiscountPercent;
    /** @var ?positive-int Default: '0' */
    public ?int $fixedIncreaseId;
    /** @var ?positive-int Default: '0' */
    public ?int $fixedIncreasePercent;
    /** Default: "0.0000000000" */
    public float $primeCost;

    /** @param array{
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
     *     goodSaleParam?: array,
     *     document?: array,
     *     good?: array,
     *     party_info?: array,
     *     min_price?: float,
     *     max_price?: float,
     *     min_price_percent?: float,
     *     max_price_percent?: float
     * } $originalDataArray
     * @throws VetmanagerApiGatewayException
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public static function fromApiResponseArray(array $originalDataArray): self
    {
        $instance = new self($originalDataArray);
        $instance->id = ToInt::fromStringOrNull($originalDataArray['id'])->getPositiveInt();
        $instance->invoiceId = ToInt::fromStringOrNull($originalDataArray['document_id'])->getPositiveInt();
        $instance->goodId = ToInt::fromStringOrNull($originalDataArray['good_id'])->getPositiveInt();
        $instance->quantity = ToFloat::fromStringOrNull((string)$originalDataArray['quantity'])->getNonZeroFloatOrNull();
        $instance->price = ToFloat::fromStringOrNull((string)$originalDataArray['price'])->getNonZeroFloatOrNull();
        $instance->responsibleUserId = ToInt::fromStringOrNull($originalDataArray['responsible_user_id'])->getPositiveIntOrNull();
        $instance->isDefaultResponsible = ToBool::fromStringOrNull($originalDataArray['is_default_responsible'])->getBoolOrThrowIfNull();
        $instance->saleParamId = ToInt::fromStringOrNull($originalDataArray['sale_param_id'])->getPositiveInt();
        $instance->tagId = ToInt::fromStringOrNull($originalDataArray['tag_id'])->getPositiveIntOrNull();
        $instance->discountType = $originalDataArray['discount_type'] ? DiscountTypeEnum::from($originalDataArray['discount_type']) : null;
        $instance->discountDocumentId = ToInt::fromStringOrNull($originalDataArray['discount_document_id'])->getPositiveIntOrNull();
        $instance->discountPercent = ToFloat::fromStringOrNull($originalDataArray['discount_percent'])->getNonZeroFloatOrNull();
        $instance->defaultPrice = ToFloat::fromStringOrNull($originalDataArray['default_price'])->getNonZeroFloatOrNull();
        $instance->createDate = ToDateTime::fromOnlyDateString($originalDataArray['create_date'])->getDateTimeOrThrow();
        $instance->discountCause = ToString::fromStringOrNull($originalDataArray['discount_cause'])->getStringEvenIfNullGiven();
        $instance->fixedDiscountId = ToInt::fromStringOrNull($originalDataArray['fixed_discount_id'])->getPositiveIntOrNull();
        $instance->fixedDiscountPercent = ToInt::fromStringOrNull($originalDataArray['fixed_discount_percent'])->getPositiveIntOrNull();
        $instance->fixedIncreaseId = ToInt::fromStringOrNull($originalDataArray['fixed_increase_id'])->getPositiveIntOrNull();
        $instance->fixedIncreasePercent = ToInt::fromStringOrNull($originalDataArray['fixed_increase_percent'])->getPositiveIntOrNull();
        $instance->primeCost = ToFloat::fromStringOrNull($originalDataArray['prime_cost'])->getNonZeroFloatOrNull();
        return $instance;
    }
}
