<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Invoice;


final class InvoicePlusClientAndPetAndDoctor extends AbstractInvoice
{
    public static function getDtoClass(): string
    {
        return InvoicePlusClientAndPetAndDoctor::class;
    }
}
