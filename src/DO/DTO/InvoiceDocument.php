<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO\DTO;

use DateTime;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\BoolContainer;
use VetmanagerApiGateway\DO\DateTimeContainer;
use VetmanagerApiGateway\DO\DTO;
use VetmanagerApiGateway\DO\Enum\InvoiceDocument\DiscountType;
use VetmanagerApiGateway\DO\FloatContainer;
use VetmanagerApiGateway\DO\IntContainer;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/** @property-read DAO\InvoiceDocumentFromGetById $self */
class InvoiceDocument extends AbstractDTO
{
    /** @var positive-int */
    public int $id;
    /** @var positive-int */
    public int $documentId;
    /** @var positive-int */
    public int $goodId;
    public ?float $quantity;
    public float $price;
    /** @var ?positive-int Default: '0' */
    public ?int $responsibleUserId;
    /** @var ?positive-int */
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
    public GoodSaleParam $goodSaleParam;

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
     *       },
     *     document?: mixed,
     *     good?: mixed,
     *     party_info?: mixed,
     *     min_price?: mixed,
     *     max_price?: mixed,
     *     min_price_percent?: mixed,
     *     max_price_percent?: mixed
     * } $originalData
     * @throws VetmanagerApiGatewayException
     */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = IntContainer::fromStringOrNull($this->originalData['id'])->positiveInt;
        $this->documentId = IntContainer::fromStringOrNull($this->originalData['document_id'])->positiveInt;
        $this->goodId = IntContainer::fromStringOrNull($this->originalData['good_id'])->positiveInt;
        $this->quantity = FloatContainer::fromStringOrNull((string)$this->originalData['quantity'])->floatOrNull;
        $this->price = FloatContainer::fromStringOrNull((string)$this->originalData['price'])->float;
        $this->responsibleUserId = IntContainer::fromStringOrNull($this->originalData['responsible_user_id'])->positiveIntOrNull;
        $this->isDefaultResponsible = BoolContainer::fromStringOrNull($this->originalData['is_default_responsible'])->bool;
        $this->saleParamId = IntContainer::fromStringOrNull($this->originalData['sale_param_id'])->positiveIntOrNull;
        $this->tagId = IntContainer::fromStringOrNull($this->originalData['tag_id'])->positiveIntOrNull;
        $this->discountType = $this->originalData['discount_type'] ? DiscountType::from($this->originalData['discount_type']) : null;
        $this->discountDocumentId = IntContainer::fromStringOrNull($this->originalData['discount_document_id'])->positiveIntOrNull;
        $this->discountPercent = FloatContainer::fromStringOrNull($this->originalData['discount_percent'])->floatOrNull;
        $this->defaultPrice = FloatContainer::fromStringOrNull($this->originalData['default_price'])->float;
        $this->createDate = DateTimeContainer::fromOnlyDateString($this->originalData['create_date'])->dateTime;
        $this->discountCause = StringContainer::fromStringOrNull($this->originalData['discount_cause'])->string;
        $this->fixedDiscountId = IntContainer::fromStringOrNull($this->originalData['fixed_discount_id'])->positiveIntOrNull;
        $this->fixedDiscountPercent = IntContainer::fromStringOrNull($this->originalData['fixed_discount_percent'])->positiveIntOrNull;
        $this->fixedIncreaseId = IntContainer::fromStringOrNull($this->originalData['fixed_increase_id'])->positiveIntOrNull;
        $this->fixedIncreasePercent = IntContainer::fromStringOrNull($this->originalData['fixed_increase_percent'])->positiveIntOrNull;
        $this->primeCost = FloatContainer::fromStringOrNull($this->originalData['prime_cost'])->float;

        $this->goodSaleParam = DTO\GoodSaleParam::fromSingleObjectContents($this->apiGateway, $this->originalData['goodSaleParam']);
    }

    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'self' => DAO\InvoiceDocumentFromGetById::getById($this->apiGateway, $this->id),
            default => $this->$name,
        };
    }
}
