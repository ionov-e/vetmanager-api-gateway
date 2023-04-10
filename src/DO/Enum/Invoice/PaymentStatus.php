<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO\Enum\Invoice;

enum PaymentStatus: string
{
    case None = 'none';
    case Partial = 'partial';
    case Full = 'full';
}
