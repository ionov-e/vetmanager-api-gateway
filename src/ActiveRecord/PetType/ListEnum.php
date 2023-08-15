<?php

namespace VetmanagerApiGateway\ActiveRecord\PetType;

enum ListEnum: string
{
    case Basic = PetTypeOnly::class;
    case PlusBreeds = PetTypePlusBreeds::class;
}
