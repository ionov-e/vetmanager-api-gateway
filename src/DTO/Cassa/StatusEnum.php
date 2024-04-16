<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Cassa;

enum StatusEnum: string
{
    case Active = 'active';
    case Deactivated = 'deactivated';
    case Deleted = 'deleted';
}
