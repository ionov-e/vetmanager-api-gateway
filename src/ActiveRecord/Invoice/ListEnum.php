<?php

namespace VetmanagerApiGateway\ActiveRecord\Invoice;

enum ListEnum: string
{
    case Basic = InvoiceOnly::class;
    case PlusClientAndPetAndDoctor = InvoicePlusClientAndPetAndDoctor::class;
    case PlusClientAndPetAndDoctorAndDocuments = InvoicePlusClientAndPetAndDoctorAndDocuments::class;
}
