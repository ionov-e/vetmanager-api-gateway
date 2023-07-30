<?php

namespace VetmanagerApiGateway\ActiveRecord\Pet;

enum ListEnum: string
{
    case Basic = PetOnly::class;
    case PlusOwnerAndTypeAndBreedAndColor = PetPlusOwnerAndTypeAndBreedAndColor::class;
}
