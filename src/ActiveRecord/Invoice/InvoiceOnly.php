<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Invoice;

use VetmanagerApiGateway\DTO\Invoice\InvoiceOnlyDto;


class InvoiceOnly extends AbstractInvoice
{
    public static function getDtoClass(): string
    {
        return InvoiceOnlyDto::class;
    }
}
