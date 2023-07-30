<?php

namespace VetmanagerApiGateway\ActiveRecord\Breed;

enum ListEnum: string
{
    case Basic = BreedOnly::class;
    case PlusPetType = BreedPlusPetType::class;

}
