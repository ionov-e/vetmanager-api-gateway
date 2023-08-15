<?php

namespace VetmanagerApiGateway\ActiveRecord\Good;

enum ListEnum: string
{
    case Basic = GoodOnly::class;
    case PlusGroupAndUnitAndSaleParams = GoodPlusGroupAndUnitAndSaleParams::class;
}
