<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Payment;

enum PaymentEnum: string
{
    case Cash = 'cash';
    case Cashless = 'cashless';
    case Combined = 'combined';
}
