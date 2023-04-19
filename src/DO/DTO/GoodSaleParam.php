<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO\DTO;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\Enum\GoodSaleParam\PriceFormation;
use VetmanagerApiGateway\DO\Enum\GoodSaleParam\Status;
use VetmanagerApiGateway\DO\FloatContainer;
use VetmanagerApiGateway\DO\IntContainer;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/** @property-read DAO\GoodSaleParam $self */
class GoodSaleParam extends AbstractDTO
{
    /** @var positive-int */
    public int $id;
    /** @var ?positive-int Default: 0 */
    public ?int $goodId;
    public ?float $price;
    /** Default: 1 */
    public float $coefficient;
    /** @var ?positive-int Default: 0 */
    public ?int $unitSaleId;
    public ?float $minPriceInPercents;
    public ?float $maxPriceInPercents;
    public string $barcode;
    /** Default: 'active' */
    public Status $status;
    /** @var ?positive-int Default: 0 */
    public ?int $clinicId;
    public ?float $markup;
    /** Default: 'fixed' */
    public PriceFormation $priceFormation;

    /** Предзагружен. Нового АПИ запроса не будет */
    public ?DAO\Unit $unit;

    /** @param array{
     *     "id": string,
     *     "good_id": string,
     *     "price": ?string,
     *     "coefficient": string,
     *     "unit_sale_id": string,
     *     "min_price": ?string,
     *     "max_price": ?string,
     *     "barcode": ?string,
     *     "status": string,
     *     "clinic_id": string,
     *     "markup": string,
     *     "price_formation": ?string,
     *     "unitSale"?: array,
     *     "good"?: array,
     * } $originalData
     * @throws VetmanagerApiGatewayException
     */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = IntContainer::fromStringOrNull($this->originalData['id'])->positiveInt;
        $this->goodId = IntContainer::fromStringOrNull($this->originalData['good_id'])->positiveIntOrNull;
        $this->price = FloatContainer::fromStringOrNull($this->originalData['price'])->floatOrNull;
        $this->coefficient = FloatContainer::fromStringOrNull($this->originalData['coefficient'])->float;
        $this->unitSaleId = IntContainer::fromStringOrNull($this->originalData['unit_sale_id'])->positiveIntOrNull;
        $this->minPriceInPercents = FloatContainer::fromStringOrNull($this->originalData['min_price'])->floatOrNull;
        $this->maxPriceInPercents = FloatContainer::fromStringOrNull($this->originalData['max_price'])->floatOrNull;
        $this->barcode = StringContainer::fromStringOrNull($this->originalData['barcode'])->string;
        $this->status = Status::from($this->originalData['status']);
        $this->clinicId = IntContainer::fromStringOrNull($this->originalData['clinic_id'])->positiveIntOrNull;
        $this->markup = FloatContainer::fromStringOrNull($this->originalData['markup'])->floatOrNull;
        $this->priceFormation = PriceFormation::from($this->originalData['price_formation']);

        $this->unit = !empty($this->originalData['unitSale'])
            ? DAO\Unit::fromSingleObjectContents($this->apiGateway, $this->originalData['unitSale'])
            : null;
    }

    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'self' => DAO\GoodSaleParam::getById($this->apiGateway, $this->id),
            default => $this->$name,
        };
    }
}
