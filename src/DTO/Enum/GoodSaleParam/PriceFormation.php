<?php

namespace VetmanagerApiGateway\DTO\Enum\GoodSaleParam;

enum PriceFormation: string
{
    case Fixed = 'fixed';
    case Increase = 'increase';
}
