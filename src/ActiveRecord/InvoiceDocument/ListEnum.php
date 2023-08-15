<?php

namespace VetmanagerApiGateway\ActiveRecord\InvoiceDocument;

enum ListEnum: string
{
    case Basic = InvoiceDocumentOnly::class;
    case PlusClientAndPetAndDoctor = InvoiceDocumentPlusGoodSaleParamAndUnitAndInvoiceAndGood::class;
    case PlusClientAndPetAndDoctorAndDocuments = InvoiceDocumentPlusGoodSaleParamAndUnitAndInvoiceAndGoodWithPartyInfoAndMinMax::class;
}
