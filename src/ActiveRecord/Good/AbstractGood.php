<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Good;

use DateTime;
use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecord\CreatableInterface;
use VetmanagerApiGateway\ActiveRecord\DeletableInterface;
use VetmanagerApiGateway\ActiveRecord\GoodGroup\GoodGroup;
use VetmanagerApiGateway\ActiveRecord\GoodSaleParam\AbstractGoodSaleParam;
use VetmanagerApiGateway\ActiveRecord\Unit\Unit;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\Good\GoodOnlyDto;
use VetmanagerApiGateway\DTO\Good\GoodOnlyDtoInterface;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade;

///**
// * @property-read GoodOnlyDto $originalDto
// * @property positive-int $id
// * @property ?positive-int $groupId
// * @property string $title
// * @property ?positive-int $unitStorageId
// * @property bool $isWarehouseAccount Default in DB: True
// * @property bool $isActive Default in DB: True
// * @property string $code
// * @property bool $isCall Default in DB: False
// * @property bool $isForSale Default in DB: True
// * @property string $barcode
// * @property ?DateTime $createDate
// * @property string $description
// * @property float $primeCost Default in DB: '0.0000000000'
// * @property ?positive-int $categoryId
// * @property-read array{
// *     id: numeric-string,
// *     group_id: ?numeric-string,
// *     title: string,
// *     unit_storage_id: ?numeric-string,
// *     is_warehouse_account: string,
// *     is_active: string,
// *     code: ?string,
// *     is_call: string,
// *     is_for_sale: string,
// *     barcode: ?string,
// *     create_date: string,
// *     description: string,
// *     prime_cost: string,
// *     category_id: ?numeric-string,
// *     group: array{
// *              id: string,
// *              title: string,
// *              is_service: string,
// *              markup: ?string,
// *              is_show_in_vaccines: string,
// *              price_id: ?string
// *     },
// *     unitStorage?: array{
// *              id: string,
// *              title: string,
// *              status: string
// *     },
// *     goodSaleParams: list<array{
// *              id: numeric-string,
// *              good_id: numeric-string,
// *              price: ?string,
// *              coefficient: string,
// *              unit_sale_id: numeric-string,
// *              min_price: ?string,
// *              max_price: ?string,
// *              barcode: ?string,
// *              status: string,
// *              clinic_id: numeric-string,
// *              markup: string,
// *              price_formation: ?string,
// *              unitSale?: array{
// *                      id: string,
// *                      title: string,
// *                      status: string
// *              }
// *     }>
// * } $originalDataArray
// * @property-read GoodGroup $group
// * @property-read ?Unit $unit
// * @property-read GoodSaleParamOnly[] $goodSaleParams
// */
abstract class AbstractGood extends AbstractActiveRecord implements GoodOnlyDtoInterface, CreatableInterface, DeletableInterface
{
    public static function getRouteKey(): string
    {
        return 'good';
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, GoodOnlyDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    /** @throws VetmanagerApiGatewayException */
    public function create(): self
    {
        return (new Facade\Good($this->activeRecordFactory))->createNewUsingArray($this->getAsArray());
    }

    /** @throws VetmanagerApiGatewayException */
    public function update(): self
    {
        return (new Facade\Good($this->activeRecordFactory))->updateUsingIdAndArray($this->getId(), $this->getAsArrayWithSetPropertiesOnly());
    }

    /** @throws VetmanagerApiGatewayException */
    public function delete(): void
    {
        (new Facade\Good($this->activeRecordFactory))->delete($this->getId());
    }

    /** @inheritDoc */
    public function getId(): int
    {
        return $this->modelDTO->getId();
    }

    /** @inheritDoc */
    public function getGroupId(): ?int
    {
        return $this->modelDTO->getGroupId();
    }

    public function getTitle(): string
    {
        return $this->modelDTO->getTitle();
    }

    /** @inheritDoc */
    public function getUnitId(): ?int
    {
        return $this->modelDTO->getUnitId();
    }

    /** @inheritDoc */
    public function getIsWarehouseAccount(): bool
    {
        return $this->modelDTO->getIsWarehouseAccount();
    }

    /** @inheritDoc */
    public function getIsActive(): bool
    {
        return $this->modelDTO->getIsActive();
    }

    public function getCode(): string
    {
        return $this->modelDTO->getCode();
    }

    /** @inheritDoc */
    public function getIsCall(): bool
    {
        return $this->modelDTO->getIsCall();
    }

    /** @inheritDoc */
    public function getIsForSale(): bool
    {
        return $this->modelDTO->getIsForSale();
    }

    public function getBarcode(): string
    {
        return $this->modelDTO->getBarcode();
    }

    /** @inheritDoc */
    public function getCreateDate(): ?DateTime
    {
        return $this->modelDTO->getCreateDate();
    }

    public function getDescription(): string
    {
        return $this->modelDTO->getDescription();
    }

    /** @inheritDoc */
    public function getPrimeCost(): float
    {
        return $this->modelDTO->getPrimeCost();
    }

    /** @inheritDoc */
    public function getCategoryId(): ?int
    {
        return $this->modelDTO->getCategoryId();
    }

    /** @inheritDoc */
    public function setGroupId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setGroupId($value));
    }

    /** @inheritDoc */
    public function setTitle(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setTitle($value));
    }

    /** @inheritDoc */
    public function setUnitStorageId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setUnitStorageId($value));
    }

    /** @inheritDoc */
    public function setIsWarehouseAccount(?bool $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setIsWarehouseAccount($value));
    }

    /** @inheritDoc */
    public function setIsActive(?bool $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setIsActive($value));
    }

    /** @inheritDoc */
    public function setCode(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setCode($value));
    }

    /** @inheritDoc */
    public function setIsCall(?bool $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setIsCall($value));
    }

    /** @inheritDoc */
    public function setIsForSale(?bool $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setIsForSale($value));
    }

    /** @inheritDoc */
    public function setBarcode(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setBarcode($value));
    }

    /** @inheritDoc */
    public function setCreateDateFromString(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setCreateDateFromString($value));
    }

    /** @inheritDoc */
    public function setCreateDateFromDateTime(DateTime $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setCreateDateFromDateTime($value));
    }

    /** @inheritDoc */
    public function setDescription(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setDescription($value));
    }

    /** @inheritDoc */
    public function setPrimeCost(?float $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setPrimeCost($value));
    }

    /** @inheritDoc */
    public function setCategoryId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setCategoryId($value));
    }

    abstract public function getGoodGroup(): ?GoodGroup;

    abstract public function getUnit(): ?Unit;

    /** @return AbstractGoodSaleParam[] */
    abstract public function getGoodSaleParams(): array;
}
