<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\InvoiceDocument;

use DateTime;
use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecord\CreatableInterface;
use VetmanagerApiGateway\ActiveRecord\DeletableInterface;
use VetmanagerApiGateway\ActiveRecord\Good\AbstractGood;
use VetmanagerApiGateway\ActiveRecord\GoodSaleParam\AbstractGoodSaleParam;
use VetmanagerApiGateway\ActiveRecord\Invoice\AbstractInvoice;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\InvoiceDocument\AbstractInvoiceDocumentOnlyDto;
use VetmanagerApiGateway\DTO\InvoiceDocument\DiscountTypeEnum;
use VetmanagerApiGateway\DTO\InvoiceDocument\InvoiceDocumentOnlyDtoInterface;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade;

///**
// * @property-read InvoiceDocumentOnlyDto $originalDto
// * @property positive-int $id
// * @property positive-int $invoiceId
// * @property positive-int $goodId
// * @property ?float $quantity
// * @property float $price
// * @property ?positive-int $responsibleUserId
// * @property bool $isDefaultResponsible
// * @property positive-int $saleParamId Не видел без ID
// * @property ?positive-int $tagId
// * @property ?DiscountTypeEnum $discountType
// * @property ?positive-int $discountDocumentId
// * @property ?float $discountPercent
// * @property float $defaultPrice
// * @property DateTime $createDate
// * @property string $discountCause
// * @property ?positive-int $fixedDiscountId
// * @property ?positive-int $fixedDiscountPercent
// * @property ?positive-int $fixedIncreaseId
// * @property ?positive-int $fixedIncreasePercent
// * @property float $primeCost
// * @property-read array{
// *     id: numeric-string,
// *     document_id: string,
// *     good_id: string,
// *     quantity: ?int|numeric-string,
// *     price: numeric|numeric-string,
// *     responsible_user_id: string,
// *     is_default_responsible: string,
// *     sale_param_id: string,
// *     tag_id: string,
// *     discount_type: ?string,
// *     discount_document_id: ?string,
// *     discount_percent: ?string,
// *     default_price: ?string,
// *     create_date: string,
// *     discount_cause: ?string,
// *     fixed_discount_id: string,
// *     fixed_discount_percent: string,
// *     fixed_increase_id: string,
// *     fixed_increase_percent: string,
// *     prime_cost: string,
// *     goodSaleParam: array{
// *              id: string,
// *              good_id: string,
// *              price: ?string,
// *              coefficient: string,
// *              unit_sale_id: string,
// *              min_price: ?string,
// *              max_price: ?string,
// *              barcode: ?string,
// *              status: string,
// *              clinic_id: string,
// *              markup: string,
// *              price_formation: ?string,
// *              unitSale: array{
// *                       id: string,
// *                       title: string,
// *                       status: string
// *              }
// *     },
// *     document: array{
// *              id: string,
// *              doctor_id: ?string,
// *              client_id: string,
// *              pet_id: string,
// *              description: string,
// *              percent: ?string,
// *              amount: ?string,
// *              status: string,
// *              invoice_date: string,
// *              old_id: ?string,
// *              night: string,
// *              increase: ?string,
// *              discount: ?string,
// *              call: string,
// *              paid_amount: string,
// *              create_date: string,
// *              payment_status: string,
// *              clinic_id: string,
// *              creator_id: ?string,
// *              fiscal_section_id: string
// *     },
// *     good: array{
// *              id: string,
// *              group_id: string,
// *              title: string,
// *              unit_storage_id: string,
// *              is_warehouse_account: string,
// *              is_active: string,
// *              code: string,
// *              is_call: string,
// *              is_for_sale: string,
// *              barcode: string,
// *              create_date: string,
// *              description: string,
// *              prime_cost: string,
// *              category_id: ?string
// *     },
// *     party_info: array,
// *     min_price: float,
// *     max_price: float,
// *     min_price_percent: float,
// *     max_price_percent: float
// * } $originalDataArray "party_info", "min_price", "max_price", "min_price_percent", "max_price_percent" Только по ID
// * @property-read InvoiceOnlyDto $invoice
// * @property-read GoodOnlyDto $good
// * @property-read GoodSaleParamOnlyDto $goodSaleParam
// * @property-read float $minPrice Приходит сейчас int, но поручиться, что float не стоит исключать (странная функция округления)
// * @property-read float $maxPrice Приходит сейчас int, но поручиться, что float не стоит исключать (странная функция округления)
// * @property-read float $minPriceInPercents Приходит сейчас int, но поручиться, что float не стоит исключать (странная функция округления)
// * @property-read float $maxPriceInPercents Приходит сейчас int, но поручиться, что float не стоит исключать (странная функция округления)
// * @property-read list<array{
// *                           party_id: string,
// *                           party_exec_date: string,
// *                           store_id: string,
// *                           good_id: string,
// *                           characteristic_id: string,
// *                           quantity: ?string,
// *                           price: ?string
// *           }> $partyInfo Не нашел примеров. Только пустой массив мне всегда приходил. Судя по всему будет такой ответ #TODO find out expected response
// */

/** @property AbstractInvoiceDocumentOnlyDto $modelDTO Без этой строки PhpStorm 2023.2 почему-то не смотрел в конструктор */
abstract class AbstractInvoiceDocument extends AbstractActiveRecord implements InvoiceDocumentOnlyDtoInterface, CreatableInterface, DeletableInterface
{
    public static function getRouteKey(): string
    {
        return 'invoiceDocument';
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, AbstractInvoiceDocumentOnlyDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
    }

    /** @throws VetmanagerApiGatewayException */
    public function create(): self
    {
        return (new Facade\InvoiceDocument($this->activeRecordFactory))->createNewUsingArray($this->getAsArrayWithSetPropertiesOnly());
    }

    /** @throws VetmanagerApiGatewayException */
    public function update(): self
    {
        return (new Facade\InvoiceDocument($this->activeRecordFactory))->updateUsingIdAndArray($this->getId(), $this->getAsArrayWithSetPropertiesOnly());
    }

    /** @throws VetmanagerApiGatewayException */
    public function delete(): void
    {
        (new Facade\InvoiceDocument($this->activeRecordFactory))->delete($this->getId());
    }

    /** @inheritDoc */
    public function getId(): int
    {
        return $this->modelDTO->getId();
    }

    /** @inheritDoc */
    public function getInvoiceId(): int
    {
        return $this->modelDTO->getInvoiceId();
    }

    /** @inheritDoc */
    public function getGoodId(): int
    {
        return $this->modelDTO->getGoodId();
    }

    /** @inheritDoc */
    public function getQuantity(): ?float
    {
        return $this->modelDTO->getQuantity();
    }

    /** @inheritDoc */
    public function getPrice(): float
    {
        return $this->modelDTO->getPrice();
    }

    /** @inheritDoc */
    public function getResponsibleUserId(): ?int
    {
        return $this->modelDTO->getResponsibleUserId();
    }

    /** @inheritDoc */
    public function getIsDefaultResponsible(): bool
    {
        return $this->modelDTO->getIsDefaultResponsible();
    }

    /** @inheritDoc */
    public function getSaleParamId(): int
    {
        return $this->modelDTO->getSaleParamId();
    }

    /** @inheritDoc */
    public function getTagId(): ?int
    {
        return $this->modelDTO->getTagId();
    }

    public function getDiscountTypeAsString(): ?string
    {
        return $this->modelDTO->getDiscountTypeAsString();
    }

    public function getDiscountTypeAsEnum(): ?DiscountTypeEnum
    {
        return $this->modelDTO->getDiscountTypeAsEnum();
    }

    /** @inheritDoc */
    public function getDiscountDocumentId(): ?int
    {
        return $this->modelDTO->getDiscountDocumentId();
    }

    /** @inheritDoc */
    public function getDiscountPercent(): ?float
    {
        return $this->modelDTO->getDiscountPercent();
    }

    /** @inheritDoc */
    public function getDefaultPrice(): ?float
    {
        return $this->modelDTO->getDefaultPrice();
    }

    /** @inheritDoc */
    public function getCreateDateAsString(): string
    {
        return $this->modelDTO->getCreateDateAsString();
    }

    /** @inheritDoc */
    public function getCreateDateAsDateTime(): DateTime
    {
        return $this->modelDTO->getCreateDateAsDateTime();
    }

    public function getDiscountCause(): string
    {
        return $this->modelDTO->getDiscountCause();
    }

    /** @inheritDoc */
    public function getFixedDiscountId(): ?int
    {
        return $this->modelDTO->getFixedDiscountId();
    }

    /** @inheritDoc */
    public function getFixedDiscountPercent(): ?int
    {
        return $this->modelDTO->getFixedDiscountPercent();
    }

    /** @inheritDoc */
    public function getFixedIncreaseId(): ?int
    {
        return $this->modelDTO->getFixedIncreaseId();
    }

    /** @inheritDoc */
    public function getFixedIncreasePercent(): ?int
    {
        return $this->modelDTO->getFixedIncreasePercent();
    }

    /** @inheritDoc */
    public function getPrimeCost(): float
    {
        return $this->modelDTO->getPrimeCost();
    }

    /** @inheritDoc */
    public function setInvoiceId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setInvoiceId($value));
    }

    /** @inheritDoc */
    public function setGoodId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setGoodId($value));
    }

    /** @inheritDoc */
    public function setQuantity(?float $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setQuantity($value));
    }

    /** @inheritDoc */
    public function setPrice(?float $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setPrice($value));
    }

    /** @inheritDoc */
    public function setResponsibleUserId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setResponsibleUserId($value));
    }

    /** @inheritDoc */
    public function setIsDefaultResponsible(?bool $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setIsDefaultResponsible($value));
    }

    /** @inheritDoc */
    public function setSaleParamId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setSaleParamId($value));
    }

    /** @inheritDoc */
    public function setTagId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setTagId($value));
    }

    /** @inheritDoc */
    public function setDiscountType(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setDiscountType($value));
    }

    /** @inheritDoc */
    public function setDiscountDocumentId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setDiscountDocumentId($value));
    }

    /** @inheritDoc */
    public function setDiscountPercent(?float $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setDiscountPercent($value));
    }

    /** @inheritDoc */
    public function setDefaultPrice(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setDefaultPrice($value));
    }

    /** @inheritDoc */
    public function setCreateDateFromString(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setCreateDateFromString($value));
    }

    /** @inheritDoc */
    public function setCreateDateFromDateTime(DateTime $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setCreateDateFromDateTime($value));
    }

    /** @inheritDoc */
    public function setDiscountCause(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setDiscountCause($value));
    }

    /** @inheritDoc */
    public function setFixedDiscountId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setFixedDiscountId($value));
    }

    /** @inheritDoc */
    public function setFixedDiscountPercent(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setFixedDiscountPercent($value));
    }

    /** @inheritDoc */
    public function setFixedIncreaseId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setFixedIncreaseId($value));
    }

    /** @inheritDoc */
    public function setFixedIncreasePercent(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setFixedIncreasePercent($value));
    }

    /** @inheritDoc */
    public function setPrimeCost(?float $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setPrimeCost($value));
    }

    abstract public function getMinPrice(): float;

    abstract public function getMaxPrice(): float;

    abstract public function getMinPriceInPercents(): float;

    abstract public function getMaxPriceInPercents(): float;

    abstract public function getPartyInfo(): array;

    abstract public function getGood(): AbstractGood;

    abstract public function getGoodSaleParam(): AbstractGoodSaleParam;

    abstract public function getInvoice(): AbstractInvoice;
}
