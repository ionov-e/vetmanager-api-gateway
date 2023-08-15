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
use VetmanagerApiGateway\DTO\InvoiceDocument\InvoiceDocumentPlusGoodSaleParamAndUnitAndInvoiceAndGoodDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade;

/** @property InvoiceDocumentPlusGoodSaleParamAndUnitAndInvoiceAndGoodDto $modelDTO*/
final class InvoiceDocumentPlusGoodSaleParamAndUnitAndInvoiceAndGood extends AbstractInvoiceDocument
{
    public static function getDtoClass(): string
    {
        return InvoiceDocumentPlusGoodSaleParamAndUnitAndInvoiceAndGoodDto::class;
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, InvoiceDocumentPlusGoodSaleParamAndUnitAndInvoiceAndGoodDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
    }

    /** Получить себя по ID, чтобы сразу получить за один запрос данные:
     * GoodSaleParam, Unit, Invoice, PartyInfo, Good, MinPrice, MaxPrice, MinPriceInPercents, MaxPriceInPercents, PartyInfo
     * @throws VetmanagerApiGatewayException
     */
    public function getFullSelf(): InvoiceDocumentPlusGoodSaleParamAndUnitAndInvoiceAndGoodWithPartyInfoAndMinMax
    {
        return (new Facade\InvoiceDocument($this->activeRecordFactory))->getById($this->getId());
    }

    /** Сначала произойдет запрос получения себя по ID {@see self::getFullSelf()}
     * @throws VetmanagerApiGatewayException
     */
    public function getMinPrice(): float
    {
        return $this->getFullSelf()->getMinPrice();
    }

    /** Сначала произойдет запрос получения себя по ID {@see self::getFullSelf()}
     * @throws VetmanagerApiGatewayException
     */
    public function getMaxPrice(): float
    {
        return $this->getFullSelf()->getMaxPrice();
    }

    /** Сначала произойдет запрос получения себя по ID {@see self::getFullSelf()}
     * @throws VetmanagerApiGatewayException
     */
    public function getMinPriceInPercents(): float
    {
        return $this->getFullSelf()->getMinPriceInPercents();
    }

    /** Сначала произойдет запрос получения себя по ID {@see self::getFullSelf()}
     * @throws VetmanagerApiGatewayException
     */
    public function getMaxPriceInPercents(): float
    {
        return $this->getFullSelf()->getMaxPriceInPercents();
    }

    /** Сначала произойдет запрос получения себя по ID {@see self::getFullSelf()}
     * @throws VetmanagerApiGatewayException
     */
    public function getPartyInfo(): array
    {
        return $this->getFullSelf()->getPartyInfo();
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
