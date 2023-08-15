<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\InvoiceDocument;

use VetmanagerApiGateway\ActiveRecord\Good\AbstractGood;
use VetmanagerApiGateway\ActiveRecord\GoodSaleParam\AbstractGoodSaleParam;
use VetmanagerApiGateway\ActiveRecord\Invoice\AbstractInvoice;
use VetmanagerApiGateway\DTO\InvoiceDocument\InvoiceDocumentOnlyDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade;

final class InvoiceDocumentOnly extends AbstractInvoiceDocument
{
    public static function getDtoClass(): string
    {
        return InvoiceDocumentOnlyDto::class;
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

    /** @throws VetmanagerApiGatewayException */
    public function getGood(): AbstractGood
    {
        return (new Facade\Good($this->activeRecordFactory))->getById($this->getGoodId());
    }

    /** @throws VetmanagerApiGatewayException */
    public function getGoodSaleParam(): AbstractGoodSaleParam
    {
        return (new Facade\GoodSaleParam($this->activeRecordFactory))->getById($this->getSaleParamId());
    }

    /** @throws VetmanagerApiGatewayException */
    public function getInvoice(): AbstractInvoice
    {
        return (new Facade\Invoice($this->activeRecordFactory))->getById($this->getInvoiceId());
    }
}
