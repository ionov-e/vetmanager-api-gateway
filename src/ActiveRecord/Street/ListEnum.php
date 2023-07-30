<?php

namespace VetmanagerApiGateway\ActiveRecord\Street;

enum ListEnum: string
{
    case Basic = StreetOnly::class;
    case PlusCity = StreetPlusCity::class;
}
