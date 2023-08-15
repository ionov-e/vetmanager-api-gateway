<?php

namespace VetmanagerApiGateway\ActiveRecord\Client;

enum ListEnum: string
{
    case Basic = ClientOnly::class;
    case PlusTypeAndCity = ClientPlusTypeAndCity::class;

}
