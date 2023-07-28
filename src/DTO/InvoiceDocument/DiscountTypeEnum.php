<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\InvoiceDocument;

enum DiscountTypeEnum: string
{
    case Card = 'card';
    case Promotion = 'promotion';
    case Coupon = 'coupon';
}
