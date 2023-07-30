<?php

namespace VetmanagerApiGateway\ActiveRecord\MedicalCard;

enum ListEnum: string
{
    case Basic = MedicalCardOnly::class;
    case PlusPet = MedicalCardPlusPet::class;
}
