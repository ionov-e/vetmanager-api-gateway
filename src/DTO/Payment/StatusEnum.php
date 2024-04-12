<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Payment;

enum StatusEnum: string
{
    case Exec = 'exec';
    case Save = 'save';
    case Deleted = 'deleted';
}

