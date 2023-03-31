<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Enum\Client;

enum Status: string
{
    case Active = 'ACTIVE';
    case Disabled = 'DISABLED';
    case Deleted = 'DELETED';
    case Temporary = 'TEMPORARY';
}
