<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use DateTime;
use VetmanagerApiGateway\DO\BoolContainer;
use VetmanagerApiGateway\DO\DateTimeContainer;
use VetmanagerApiGateway\DO\FloatContainer;
use VetmanagerApiGateway\DO\IntContainer;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\DTO\Enum\InvoiceDocument\DiscountType;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class InvoiceDocumentDto extends AbstractDTO
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
     * } $originalData
     * @throws VetmanagerApiGatewayException
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public static function fromApiResponseArray(array $originalData): self
    {
        $instance = new self();
        $instance->id = IntContainer::fromStringOrNull($originalData['id'])->positiveInt;
        $instance->invoiceId = IntContainer::fromStringOrNull($originalData['document_id'])->positiveInt;
        $instance->goodId = IntContainer::fromStringOrNull($originalData['good_id'])->positiveInt;
        $instance->quantity = FloatContainer::fromStringOrNull((string)$originalData['quantity'])->floatOrNull;
        $instance->price = FloatContainer::fromStringOrNull((string)$originalData['price'])->float;
        $instance->responsibleUserId = IntContainer::fromStringOrNull($originalData['responsible_user_id'])->positiveIntOrNull;
        $instance->isDefaultResponsible = BoolContainer::fromStringOrNull($originalData['is_default_responsible'])->bool;
        $instance->saleParamId = IntContainer::fromStringOrNull($originalData['sale_param_id'])->positiveIntOrNull;
        $instance->tagId = IntContainer::fromStringOrNull($originalData['tag_id'])->positiveIntOrNull;
        $instance->discountType = $originalData['discount_type'] ? DiscountType::from($originalData['discount_type']) : null;
        $instance->discountDocumentId = IntContainer::fromStringOrNull($originalData['discount_document_id'])->positiveIntOrNull;
        $instance->discountPercent = FloatContainer::fromStringOrNull($originalData['discount_percent'])->floatOrNull;
        $instance->defaultPrice = FloatContainer::fromStringOrNull($originalData['default_price'])->float;
        $instance->createDate = DateTimeContainer::fromOnlyDateString($originalData['create_date'])->dateTime;
        $instance->discountCause = StringContainer::fromStringOrNull($originalData['discount_cause'])->string;
        $instance->fixedDiscountId = IntContainer::fromStringOrNull($originalData['fixed_discount_id'])->positiveIntOrNull;
        $instance->fixedDiscountPercent = IntContainer::fromStringOrNull($originalData['fixed_discount_percent'])->positiveIntOrNull;
        $instance->fixedIncreaseId = IntContainer::fromStringOrNull($originalData['fixed_increase_id'])->positiveIntOrNull;
        $instance->fixedIncreasePercent = IntContainer::fromStringOrNull($originalData['fixed_increase_percent'])->positiveIntOrNull;
        $instance->primeCost = FloatContainer::fromStringOrNull($originalData['prime_cost'])->float;
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
            isset($this->invoiceId) ? ['document_id' => $this->invoiceId] : [],
            isset($this->goodId) ? ['good_id' => $this->goodId] : [],
            isset($this->quantity) ? ['quantity' => $this->quantity] : [],
            isset($this->price) ? ['price' => $this->price] : [],
            isset($this->responsibleUserId) ? ['responsible_user_id' => $this->responsibleUserId] : [],
            isset($this->isDefaultResponsible) ? ['is_default_responsible' => (int)$this->isDefaultResponsible] : [],
            isset($this->saleParamId) ? ['sale_param_id' => $this->saleParamId] : [],
            isset($this->tagId) ? ['tag_id' => $this->tagId] : [],
            isset($this->discountType) ? ['discount_type' => $this->discountType] : [],
            isset($this->discountDocumentId) ? ['discount_document_id' => $this->discountDocumentId] : [],
            isset($this->discountPercent) ? ['discount_percent' => $this->discountPercent] : [],
            isset($this->defaultPrice) ? ['default_price' => $this->defaultPrice] : [],
            isset($this->createDate) ? ['create_date' => $this->createDate->format('Y-m-d H:i:s')] : [],
            isset($this->discountCause) ? ['discount_cause' => $this->discountCause] : [],
            isset($this->fixedDiscountId) ? ['fixed_discount_id' => $this->fixedDiscountId] : [],
            isset($this->fixedDiscountPercent) ? ['fixed_discount_percent' => $this->fixedDiscountPercent] : [],
            isset($this->fixedIncreaseId) ? ['fixed_increase_id' => $this->fixedIncreaseId] : [],
            isset($this->fixedIncreasePercent) ? ['fixed_increase_percent' => $this->fixedIncreasePercent] : [],
            isset($this->primeCost) ? ['prime_cost' => $this->primeCost] : [],
        );
    }
}
