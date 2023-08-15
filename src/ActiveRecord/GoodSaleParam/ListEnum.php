<?php

namespace VetmanagerApiGateway\ActiveRecord\GoodSaleParam;

enum ListEnum: string
{
    case Basic = GoodSaleParamOnly::class;
    case PlusUnitAndGood = GoodSaleParamPlusUnitAndGood::class;
}
