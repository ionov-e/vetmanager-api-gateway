<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\InvoiceDocument;

use VetmanagerApiGateway\DTO\InvoiceDocument\InvoiceDocumentPlusGoodSaleParamWithUnitAndDocumentAndGoodAndMinMaxDto;

final class InvoicePlusClientAndPetAndDoctorAndDocuments extends AbstractInvoiceDocument
{
    public static function getDtoClass(): string
    {
        return InvoiceDocumentPlusGoodSaleParamWithUnitAndDocumentAndGoodAndMinMaxDto::class;
    }
}
