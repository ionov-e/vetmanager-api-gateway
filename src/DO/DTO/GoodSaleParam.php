<?php

/** @noinspection PhpFullyQualifiedNameUsageInspection */
declare(strict_types=1);

namespace VetmanagerApiGateway\DO\DTO;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\Enum\GoodSaleParam\PriceFormation;
use VetmanagerApiGateway\DO\Enum\GoodSaleParam\Status;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/** @property-read DAO\GoodSaleParam $self */
class GoodSaleParam extends AbstractDTO
{
    public int $id;
    /** Default: 0 */
    public int $goodId;
    public ?float $price;
    /** Default: 1 */
    public float $coefficient;
    /** Default: 0 */
    public int $unitSaleId;
    public ?float $minPriceInPercents;
    public ?float $maxPriceInPercents;
    public ?string $barcode;
    /** Default: 'active' */
    public Status $status;
    /** Default: 0 */
    public int $clinicId;
    public ?float $markup;
    /** Default: 'fixed' */
    public PriceFormation $priceFormation;

    /** Предзагружен. Нового АПИ запроса не будет */
    public \VetmanagerApiGateway\DO\DTO\DAO\Unit $unit;

    /** @var array{
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
     *     "price_formation": ?string
     * } $originalData
     */
    protected readonly array $originalData;

    /** @throws VetmanagerApiGatewayException
     * @throws \Exception
     */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = (int)$this->originalData['id'];
        $this->goodId = (int)$this->originalData['good_id'];
        $this->price = $this->originalData['price'] ? (int)$this->originalData['price'] : null;
        $this->coefficient = (float)$this->originalData['coefficient'];
        $this->unitSaleId = (int)$this->originalData['unit_sale_id'];
        $this->minPriceInPercents = $this->originalData['min_price'] ? (float)$this->originalData['min_price'] : null;
        $this->maxPriceInPercents = $this->originalData['max_price'] ? (float)$this->originalData['max_price'] : null;
        $this->barcode = $this->originalData['barcode'] ? (string)$this->originalData['barcode'] : null;
        $this->status = Status::from($this->originalData['status']);
        $this->clinicId = (int)$this->originalData['clinic_id'];
        $this->markup = $this->originalData['markup'] ? (float)$this->originalData['markup'] : null;
        $this->priceFormation = PriceFormation::from($this->originalData['price_formation']);
        $this->unit = \VetmanagerApiGateway\DO\DTO\DAO\Unit::fromSingleObjectContents($this->apiGateway, $this->originalData['unitSale']);
    }

    /** @throws VetmanagerApiGatewayException
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'self' => DAO\GoodSaleParam::getById($this->apiGateway, $this->id),
            default => $this->$name,
        };
    }
}
