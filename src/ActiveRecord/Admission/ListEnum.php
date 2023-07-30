<?php

namespace VetmanagerApiGateway\ActiveRecord\Admission;

enum ListEnum: string
{
    case Basic = AdmissionOnly::class;
    case PlusClientAndPetAndInvoices = AdmissionPlusClientAndPetAndInvoices::class;
    case PlusClientAndPetAndInvoicesAndTypeAndUser = AdmissionPlusClientAndPetAndInvoicesAndTypeAndUser::class;

}
