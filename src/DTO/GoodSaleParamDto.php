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
     * } $originalData
     * @throws VetmanagerApiGatewayException
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public static function fromApiResponseArray(array $originalData): self
    {
        $instance = new self();
        $instance->id = ApiInt::fromStringOrNull($originalData['id'])->positiveInt;
        $instance->goodId = ApiInt::fromStringOrNull($originalData['good_id'])->positiveIntOrNull;
        $instance->price = ApiFloat::fromStringOrNull($originalData['price'])->floatOrNull;
        $instance->coefficient = ApiFloat::fromStringOrNull($originalData['coefficient'])->float;
        $instance->unitSaleId = ApiInt::fromStringOrNull($originalData['unit_sale_id'])->positiveIntOrNull;
        $instance->minPriceInPercents = ApiFloat::fromStringOrNull($originalData['min_price'])->floatOrNull;
        $instance->maxPriceInPercents = ApiFloat::fromStringOrNull($originalData['max_price'])->floatOrNull;
        $instance->barcode = ApiString::fromStringOrNull($originalData['barcode'])->string;
        $instance->status = Status::from($originalData['status']);
        $instance->clinicId = ApiInt::fromStringOrNull($originalData['clinic_id'])->positiveIntOrNull;
        $instance->markup = ApiFloat::fromStringOrNull($originalData['markup'])->floatOrNull;
        $instance->priceFormation = PriceFormation::from((string)$originalData['price_formation']);
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
            isset($this->goodId) ? ['good_id' => $this->goodId] : [],
            isset($this->price) ? ['price' => $this->price] : [],
            isset($this->coefficient) ? ['coefficient' => $this->coefficient] : [],
            isset($this->unitSaleId) ? ['unit_sale_id' => $this->unitSaleId] : [],
            isset($this->minPriceInPercents) ? ['min_price' => $this->minPriceInPercents] : [],
            isset($this->maxPriceInPercents) ? ['max_price' => $this->maxPriceInPercents] : [],
            isset($this->barcode) ? ['barcode' => $this->barcode] : [],
            isset($this->status) ? ['status' => $this->status->value] : [],
            isset($this->clinicId) ? ['clinic_id' => $this->clinicId] : [],
            isset($this->markup) ? ['markup' => $this->markup] : [],
            isset($this->priceFormation) ? ['price_formation' => $this->priceFormation->value] : [],
        );
    }

}
