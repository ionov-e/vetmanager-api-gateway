<?php

namespace VetmanagerApiGateway\DTO\GoodSaleParam;

enum PriceFormationEnum: string
{
    case Fixed = 'fixed';
    case Increase = 'increase';
}
