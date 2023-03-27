<?php

namespace VetmanagerApiGateway\Enum\GoodSaleParam;

enum PriceFormation: string
{
    case Fixed = 'fixed';
    case Increase = 'increase';
}
