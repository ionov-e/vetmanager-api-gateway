<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\InvoiceDocument;

use VetmanagerApiGateway\DTO\InvoiceDocument\InvoiceDocumentPlusGoodSaleParamWithUnitAndDocumentAndGoodDto;

final class InvoiceDocumentPlusClientAndPetAndDoctor extends AbstractInvoiceDocument
{
    public static function getDtoClass(): string
    {
        return InvoiceDocumentPlusGoodSaleParamWithUnitAndDocumentAndGoodDto::class;
    }
}
