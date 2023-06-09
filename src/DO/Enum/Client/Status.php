<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO\Enum\Client;

enum Status: string
{
    case Active = 'ACTIVE';
    case Disabled = 'DISABLED';
    case Deleted = 'DELETED';
    case Temporary = 'TEMPORARY';
}
