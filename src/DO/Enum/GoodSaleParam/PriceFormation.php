<?php

namespace VetmanagerApiGateway\DO\Enum\GoodSaleParam;

enum PriceFormation: string
{
    case Fixed = 'fixed';
    case Increase = 'increase';
}
