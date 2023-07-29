<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\InvoiceDocument;

use VetmanagerApiGateway\DTO\InvoiceDocument\InvoiceDocumentOnlyDto;

final class InvoiceDocumentOnly extends AbstractInvoiceDocument
{
    public static function getDtoClass(): string
    {
        return InvoiceDocumentOnlyDto::class;
    }
}
