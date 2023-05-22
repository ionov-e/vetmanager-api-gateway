<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use VetmanagerApiGateway\DTO\Enum\GoodSaleParam\PriceFormation;
use VetmanagerApiGateway\DTO\Enum\GoodSaleParam\Status;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Hydrator\ApiFloat;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;

/** @psalm-suppress PropertyNotSetInConstructor, RedundantPropertyInitializationCheck - одобрено в доках PSALM для этого случая */
final class GoodSaleParamDto extends AbstractDTO
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

    /** @param array{
     *     id: numeric-string,
     *     good_id: numeric-string,
     *     price: ?string,
     *     coefficient: string,
     *     unit_sale_id: numeric-string,
     *     min_price: ?string,
     *     max_price: ?string,
     *     barcode: ?string,
     *     status: string,
     *     clinic_id: numeric-string,
     *     markup: string,
     *     price_formation: ?string,
     *     unitSale?: array,
     *     good?: array
     * } $originalDataArray
     * @throws VetmanagerApiGatewayException
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public static function fromApiResponseArray(array $originalDataArray): self
    {
        $instance = new self($originalDataArray);
        $instance->id = ApiInt::fromStringOrNull($originalDataArray['id'])->positiveInt;
        $instance->goodId = ApiInt::fromStringOrNull($originalDataArray['good_id'])->positiveIntOrNull;
        $instance->price = ApiFloat::fromStringOrNull($originalDataArray['price'])->floatOrNull;
        $instance->coefficient = ApiFloat::fromStringOrNull($originalDataArray['coefficient'])->float;
        $instance->unitSaleId = ApiInt::fromStringOrNull($originalDataArray['unit_sale_id'])->positiveIntOrNull;
        $instance->minPriceInPercents = ApiFloat::fromStringOrNull($originalDataArray['min_price'])->floatOrNull;
        $instance->maxPriceInPercents = ApiFloat::fromStringOrNull($originalDataArray['max_price'])->floatOrNull;
        $instance->barcode = ApiString::fromStringOrNull($originalDataArray['barcode'])->string;
        $instance->status = Status::from($originalDataArray['status']);
        $instance->clinicId = ApiInt::fromStringOrNull($originalDataArray['clinic_id'])->positiveIntOrNull;
        $instance->markup = ApiFloat::fromStringOrNull($originalDataArray['markup'])->floatOrNull;
        $instance->priceFormation = PriceFormation::from((string)$originalDataArray['price_formation']);
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
            property_exists($this, 'goodId') ? ['good_id' => $this->goodId] : [],
            property_exists($this, 'price') ? ['price' => $this->price] : [],
            property_exists($this, 'coefficient') ? ['coefficient' => $this->coefficient] : [],
            property_exists($this, 'unitSaleId') ? ['unit_sale_id' => $this->unitSaleId] : [],
            property_exists($this, 'minPriceInPercents') ? ['min_price' => $this->minPriceInPercents] : [],
            property_exists($this, 'maxPriceInPercents') ? ['max_price' => $this->maxPriceInPercents] : [],
            property_exists($this, 'barcode') ? ['barcode' => $this->barcode] : [],
            property_exists($this, 'status') ? ['status' => $this->status->value] : [],
            property_exists($this, 'clinicId') ? ['clinic_id' => $this->clinicId] : [],
            property_exists($this, 'markup') ? ['markup' => $this->markup] : [],
            property_exists($this, 'priceFormation') ? ['price_formation' => $this->priceFormation->value] : [],
        );
    }

}
