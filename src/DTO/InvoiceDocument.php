<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use DateTime;
use Exception;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO\Enum\InvoiceDocument\DiscountType;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/** @property-read DAO\InvoiceDocument $self */
class InvoiceDocument extends AbstractDTO
{
    public int $id;
    public int $documentId;
    public int $goodId;
    public ?float $quantity;
    /** Приходит сейчас int, но поручиться, что float не стоит исключать*/
    public ?float $price;
    /** Default: '0' */
    public int $responsibleUserId;
    public int $isDefaultResponsible;
    /** Default: '0' */
    public int $saleParamId;
    /** Default: '0' */
    public int $tagId;
    public ?DiscountType $discountType;
    public ?int $discountDocumentId;
    public ?float $discountPercent;
    public ?float $defaultPrice;
    public DateTime $createDate;
    public ?string $discountCause;
    /** Default: '0' */
    public ?int $fixedDiscountId;
    /** Default: '0' */
    public int $fixedDiscountPercent;
    /** Default: '0' */
    public int $fixedIncreaseId;
    /** Default: '0' */
    public int $fixedIncreasePercent;
    /** Default: "0.0000000000" */
    public float $primeCost;

    /** @var array<int, array{
     *           "party_id": string,
     *           "party_exec_date": string,
     *           "store_id": string,
     *           "good_id": string,
     *           "characteristic_id": string,
     *           "quantity": ?string,
     *           "price": ?string
     *           } $partyInfo
     * Не нашел примеров. Только пустой массив мне всегда приходил. Судя по всему будет такой ответ #TODO find out expected response
     */
    public array $partyInfo;
    public GoodSaleParam $goodSaleParam;
    /** @var array{
     *     "id": string,
     *     "document_id": string,
     *     "good_id": string,
     *     "quantity": ?int,
     *     "price": ?float,
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
     *     "party_info": array,
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
     *       }
     * }
     */
    protected readonly array $originalData;

    /** @throws VetmanagerApiGatewayException
     */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = (int)$this->originalData['id'];
        $this->documentId = (int)$this->originalData['document_id'];
        $this->goodId = (int)$this->originalData['good_id'];
        $this->quantity = $this->originalData['quantity'] ? (float)$this->originalData['quantity'] : null;
        $this->price = $this->originalData['price'] ? (float)$this->originalData['price'] : null;
        $this->responsibleUserId = (int)$this->originalData['responsible_user_id'];
        $this->isDefaultResponsible = (int)$this->originalData['is_default_responsible'];
        $this->saleParamId = (int)$this->originalData['sale_param_id'];
        $this->tagId = (int)$this->originalData['tag_id'];
        $this->discountType = $this->originalData['discount_type'] ? DiscountType::from($this->originalData['discount_type']) : null;
        $this->discountDocumentId = $this->originalData['discount_document_id'] ? (int)$this->originalData['discount_document_id'] : null;
        $this->discountPercent = $this->originalData['discount_percent'] ? (float)$this->originalData['discount_percent'] : null;
        $this->defaultPrice = $this->originalData['default_price'] ? (float)$this->originalData['default_price'] : null;
        $this->discountCause = $this->originalData['discount_cause'] ? (string)$this->originalData['discount_cause'] : null;
        $this->fixedDiscountId = (int)$this->originalData['fixed_discount_id'];
        $this->fixedDiscountPercent = (int)$this->originalData['fixed_discount_percent'];
        $this->fixedIncreaseId = (int)$this->originalData['fixed_increase_id'];
        $this->fixedIncreasePercent = (int)$this->originalData['fixed_increase_percent'];
        $this->primeCost = (int)$this->originalData['prime_cost'];
        $this->partyInfo = (array)$this->originalData['party_info'];

        $this->goodSaleParam = GoodSaleParam::fromSingleObjectContents($this->apiGateway, $this->originalData['goodSaleParam']);

        try {
            $this->createDate = new DateTime($this->originalData['create_date']);
        } catch (Exception $e) {
            throw new VetmanagerApiGatewayException($e->getMessage());
        }
    }

    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'self' => DAO\InvoiceDocument::getById($this->apiGateway, $this->id),
            default => $this->$name,
        };
    }
}
