<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Invoice;

use VetmanagerApiGateway\DTO\Invoice\InvoicePlusClientAndPetAndDoctorAndDocumentsDto;


final class InvoicePlusClientAndPetAndDoctorAndDocuments extends AbstractInvoice

{
    public static function getDtoClass(): string
    {
        return InvoicePlusClientAndPetAndDoctorAndDocumentsDto::class;
    }
}
