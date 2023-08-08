<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\InvoiceDocument;

use VetmanagerApiGateway\ActiveRecord\Good\AbstractGood;
use VetmanagerApiGateway\ActiveRecord\Good\GoodOnly;
use VetmanagerApiGateway\ActiveRecord\GoodSaleParam\AbstractGoodSaleParam;
use VetmanagerApiGateway\ActiveRecord\GoodSaleParam\GoodSaleParamOnly;
use VetmanagerApiGateway\ActiveRecord\Invoice\AbstractInvoice;
use VetmanagerApiGateway\ActiveRecord\Invoice\InvoiceOnly;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\InvoiceDocument\InvoiceDocumentPlusGoodSaleParamAndUnitAndInvoiceAndGoodWithPartyInfoAndMinMaxDto;

/** @property InvoiceDocumentPlusGoodSaleParamAndUnitAndInvoiceAndGoodWithPartyInfoAndMinMaxDto $modelDTO */
final class InvoiceDocumentPlusGoodSaleParamAndUnitAndInvoiceAndGoodWithPartyInfoAndMinMax extends AbstractInvoiceDocument
{
    public static function getDtoClass(): string
    {
        return InvoiceDocumentPlusGoodSaleParamAndUnitAndInvoiceAndGoodWithPartyInfoAndMinMaxDto::class;
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, InvoiceDocumentPlusGoodSaleParamAndUnitAndInvoiceAndGoodWithPartyInfoAndMinMaxDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
    }

    public function getMinPrice(): float
    {
        return $this->modelDTO->getMinPrice();
    }

    public function getMaxPrice(): float
    {
        return $this->modelDTO->getMaxPrice();
    }

    public function getMinPriceInPercents(): float
    {
        return $this->modelDTO->getMinPriceInPercents();
    }

    public function getMaxPriceInPercents(): float
    {
        return $this->modelDTO->getMaxPriceInPercents();
    }

    public function getPartyInfo(): array
    {
        return $this->modelDTO->getPartyInfo();
    }

    public function getGood(): AbstractGood
    {
        return $this->activeRecordFactory->getFromSingleDto($this->modelDTO->getGoodOnlyDto(), GoodOnly::class);
    }

    public function getGoodSaleParam(): AbstractGoodSaleParam
    {
        return $this->activeRecordFactory->getFromSingleDto($this->modelDTO->getGoodSaleParamOnlyDto(), GoodSaleParamOnly::class);
    }

    public function getInvoice(): AbstractInvoice
    {
        return $this->activeRecordFactory->getFromSingleDto($this->modelDTO->getInvoiceOnlyDto(), InvoiceOnly::class);
    }
}
