<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Invoice;

enum PaymentStatusEnum: string
{
    case None = 'none';
    case Partial = 'partial';
    case Full = 'full';
}
