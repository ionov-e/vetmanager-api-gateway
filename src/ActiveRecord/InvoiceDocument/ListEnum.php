<?php

namespace VetmanagerApiGateway\ActiveRecord\InvoiceDocument;

enum ListEnum: string
{
    case Basic = InvoiceDocumentOnly::class;
    case PlusClientAndPetAndDoctor = InvoiceDocumentPlusClientAndPetAndDoctor::class;
    case PlusClientAndPetAndDoctorAndDocuments = InvoiceDocumentPlusClientAndPetAndDoctorAndDocuments::class;
}
