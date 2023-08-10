<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\GoodSaleParam;

use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecord\CreatableInterface;
use VetmanagerApiGateway\ActiveRecord\DeletableInterface;
use VetmanagerApiGateway\ActiveRecord\Good\AbstractGood;
use VetmanagerApiGateway\ActiveRecord\Unit\Unit;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\GoodSaleParam\GoodSaleParamOnlyDto;
use VetmanagerApiGateway\DTO\GoodSaleParam\GoodSaleParamOnlyDtoInterface;
use VetmanagerApiGateway\DTO\GoodSaleParam\PriceFormationEnum;
use VetmanagerApiGateway\DTO\GoodSaleParam\StatusEnum;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade;

///**
// * @property-read GoodSaleParamOnlyDto $originalDto
// * @property positive-int id
// * @property ?positive-int goodId
// * @property ?float price
// * @property float coefficient
// * @property ?positive-int unitSaleId
// * @property ?float minPriceInPercents
// * @property ?float maxPriceInPercents
// * @property string barcode
// * @property StatusEnum status Default: 'active'
// * @property ?positive-int clinicId
// * @property ?float markup
// * @property PriceFormationEnum priceFormation
// * @property-read array{
// *     id: string,
// *     good_id: string,
// *     price: ?string,
// *     coefficient: string,
// *     unit_sale_id: string,
// *     min_price: ?string,
// *     max_price: ?string,
// *     barcode: ?string,
// *     status: string,
// *     clinic_id: string,
// *     markup: string,
// *     price_formation: ?string,
// *     unitSale?: array{
// *             id: string,
// *             title: string,
// *             status: string
// *     },
// *     good: array{
// *              id: string,
// *              group_id: ?string,
// *              title: string,
// *              unit_storage_id: ?string,
// *              is_warehouse_account: string,
// *              is_active: string,
// *              code: ?string,
// *              is_call: string,
// *              is_for_sale: string,
// *              barcode: ?string,
// *              create_date: string,
// *              description: string,
// *              prime_cost: string,
// *              category_id: ?string
// *     }
// * } $originalDataArray 'unitSale' и 'good' присутствуют и при GetById и GetAll
// * @property-read ?Unit $unit
// * @property-read GoodOnly $good
// */
abstract class AbstractGoodSaleParam extends AbstractActiveRecord implements GoodSaleParamOnlyDtoInterface, CreatableInterface, DeletableInterface
{
    public static function getRouteKey(): string
    {
        return 'goodSaleParam';
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, GoodSaleParamOnlyDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    /** @throws VetmanagerApiGatewayException */
    public function create(): self
    {
        return (new Facade\GoodSaleParam($this->activeRecordFactory))->createNewUsingArray($this->getAsArray());
    }

    /** @throws VetmanagerApiGatewayException */
    public function update(): self
    {
        return (new Facade\GoodSaleParam($this->activeRecordFactory))->updateUsingIdAndArray($this->getId(), $this->getAsArrayWithSetPropertiesOnly());
    }

    /** @throws VetmanagerApiGatewayException */
    public function delete(): void
    {
        (new Facade\GoodSaleParam($this->activeRecordFactory))->delete($this->getId());
    }

    /** @inheritDoc */
    public function getId(): int
    {
        return $this->modelDTO->getId();
    }

    /** @inheritDoc */
    public function getGoodId(): ?int
    {
        return $this->modelDTO->getGoodId();
    }

    /** @inheritDoc */
    public function getPrice(): ?float
    {
        return $this->modelDTO->getPrice();
    }

    /** @inheritDoc */
    public function getCoefficient(): float
    {
        return $this->modelDTO->getCoefficient();
    }

    /** @inheritDoc */
    public function getUnitSaleId(): ?int
    {
        return $this->modelDTO->getUnitSaleId();
    }

    /** @inheritDoc */
    public function getMinPrice(): ?float
    {
        return $this->modelDTO->getMinPrice();
    }

    /** @inheritDoc */
    public function getMaxPrice(): ?float
    {
        return $this->modelDTO->getMaxPrice();
    }

    public function getBarcode(): string
    {
        return $this->modelDTO->getBarcode();
    }

    /** @inheritDoc */
    public function getStatus(): \VetmanagerApiGateway\DTO\GoodSaleParam\StatusEnum
    {
        return $this->modelDTO->getStatus();
    }

    /** @inheritDoc */
    public function getClinicId(): ?int
    {
        return $this->modelDTO->getClinicId();
    }

    /** @inheritDoc */
    public function getMarkup(): ?float
    {
        return $this->modelDTO->getMarkup();
    }

    /** @inheritDoc */
    public function getPriceFormationAsEnum(): PriceFormationEnum
    {
        return $this->modelDTO->getPriceFormationAsEnum();
    }

    /** @inheritDoc */
    public function setGoodId(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setGoodId($value));
    }

    /** @inheritDoc */
    public function setPrice(?float $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setPrice($value));
    }

    /** @inheritDoc */
    public function setCoefficient(?float $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setCoefficient($value));
    }

    /** @inheritDoc */
    public function setUnitSaleId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setUnitSaleId($value));
    }

    /** @inheritDoc */
    public function setMinPrice(?float $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setMinPrice($value));
    }

    /** @inheritDoc */
    public function setMaxPrice(?float $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setMaxPrice($value));
    }

    /** @inheritDoc */
    public function setBarcode(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setBarcode($value));
    }

    /** @inheritDoc */
    public function setStatusFromString(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setStatusFromString($value));
    }

    /** @inheritDoc */
    public function setStatusFromEnum(StatusEnum $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setStatusFromEnum($value));
    }

    /** @inheritDoc */
    public function setClinicId(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setClinicId($value));
    }

    /** @inheritDoc */
    public function setMarkup(?float $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setMarkup($value));
    }

    /** @inheritDoc */
    public function setPriceFormationFromString(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setPriceFormationFromString($value));
    }

    /** @inheritDoc */
    public function setPriceFormationFromEnum(PriceFormationEnum $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setPriceFormationFromEnum($value));
    }

    abstract public function getGood(): AbstractGood;

    abstract public function getUnit(): ?Unit;
}
