<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use DateTime;
use VetmanagerApiGateway\DTO\Enum\InvoiceDocument\DiscountType;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Hydrator\ApiBool;
use VetmanagerApiGateway\Hydrator\ApiDateTime;
use VetmanagerApiGateway\Hydrator\ApiFloat;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;

/** @psalm-suppress PropertyNotSetInConstructor, RedundantPropertyInitializationCheck - одобрено в доках PSALM для этого случая */
final class InvoiceDocumentDto extends AbstractDTO
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
    /** @var ?positive-int Default: '0' */
    public ?int $saleParamId;
    /** @var ?positive-int Default: '0' */
    public ?int $tagId;
    public ?DiscountType $discountType;
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
        $instance->id = ApiInt::fromStringOrNull($originalDataArray['id'])->positiveInt;
        $instance->invoiceId = ApiInt::fromStringOrNull($originalDataArray['document_id'])->positiveInt;
        $instance->goodId = ApiInt::fromStringOrNull($originalDataArray['good_id'])->positiveInt;
        $instance->quantity = ApiFloat::fromStringOrNull((string)$originalDataArray['quantity'])->floatOrNull;
        $instance->price = ApiFloat::fromStringOrNull((string)$originalDataArray['price'])->float;
        $instance->responsibleUserId = ApiInt::fromStringOrNull($originalDataArray['responsible_user_id'])->positiveIntOrNull;
        $instance->isDefaultResponsible = ApiBool::fromStringOrNull($originalDataArray['is_default_responsible'])->bool;
        $instance->saleParamId = ApiInt::fromStringOrNull($originalDataArray['sale_param_id'])->positiveIntOrNull;
        $instance->tagId = ApiInt::fromStringOrNull($originalDataArray['tag_id'])->positiveIntOrNull;
        $instance->discountType = $originalDataArray['discount_type'] ? DiscountType::from($originalDataArray['discount_type']) : null;
        $instance->discountDocumentId = ApiInt::fromStringOrNull($originalDataArray['discount_document_id'])->positiveIntOrNull;
        $instance->discountPercent = ApiFloat::fromStringOrNull($originalDataArray['discount_percent'])->floatOrNull;
        $instance->defaultPrice = ApiFloat::fromStringOrNull($originalDataArray['default_price'])->float;
        $instance->createDate = ApiDateTime::fromOnlyDateString($originalDataArray['create_date'])->dateTime;
        $instance->discountCause = ApiString::fromStringOrNull($originalDataArray['discount_cause'])->string;
        $instance->fixedDiscountId = ApiInt::fromStringOrNull($originalDataArray['fixed_discount_id'])->positiveIntOrNull;
        $instance->fixedDiscountPercent = ApiInt::fromStringOrNull($originalDataArray['fixed_discount_percent'])->positiveIntOrNull;
        $instance->fixedIncreaseId = ApiInt::fromStringOrNull($originalDataArray['fixed_increase_id'])->positiveIntOrNull;
        $instance->fixedIncreasePercent = ApiInt::fromStringOrNull($originalDataArray['fixed_increase_percent'])->positiveIntOrNull;
        $instance->primeCost = ApiFloat::fromStringOrNull($originalDataArray['prime_cost'])->float;
        return $instance;
    }

    /** @inheritdoc */
    public function getRequiredKeysForPostArray(): array #TODO No Idea
    {
        return [];
    }

    /** @inheritdoc */
    protected function getSetValuesWithoutId(): array
    {
        return array_merge(
            property_exists($this, 'invoiceId') ? ['document_id' => $this->invoiceId] : [],
            property_exists($this, 'goodId') ? ['good_id' => $this->goodId] : [],
            property_exists($this, 'quantity') ? ['quantity' => $this->quantity] : [],
            property_exists($this, 'price') ? ['price' => $this->price] : [],
            property_exists($this, 'responsibleUserId') ? ['responsible_user_id' => $this->responsibleUserId] : [],
            property_exists($this, 'isDefaultResponsible') ? ['is_default_responsible' => (int)$this->isDefaultResponsible] : [],
            property_exists($this, 'saleParamId') ? ['sale_param_id' => $this->saleParamId] : [],
            property_exists($this, 'tagId') ? ['tag_id' => $this->tagId] : [],
            property_exists($this, 'discountType') ? ['discount_type' => $this->discountType] : [],
            property_exists($this, 'discountDocumentId') ? ['discount_document_id' => $this->discountDocumentId] : [],
            property_exists($this, 'discountPercent') ? ['discount_percent' => $this->discountPercent] : [],
            property_exists($this, 'defaultPrice') ? ['default_price' => $this->defaultPrice] : [],
            property_exists($this, 'createDate') ? ['create_date' => $this->createDate->format('Y-m-d H:i:s')] : [],
            property_exists($this, 'discountCause') ? ['discount_cause' => $this->discountCause] : [],
            property_exists($this, 'fixedDiscountId') ? ['fixed_discount_id' => $this->fixedDiscountId] : [],
            property_exists($this, 'fixedDiscountPercent') ? ['fixed_discount_percent' => $this->fixedDiscountPercent] : [],
            property_exists($this, 'fixedIncreaseId') ? ['fixed_increase_id' => $this->fixedIncreaseId] : [],
            property_exists($this, 'fixedIncreasePercent') ? ['fixed_increase_percent' => $this->fixedIncreasePercent] : [],
            property_exists($this, 'primeCost') ? ['prime_cost' => $this->primeCost] : [],
        );
    }
}
