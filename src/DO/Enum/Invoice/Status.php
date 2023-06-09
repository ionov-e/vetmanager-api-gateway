<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO\Enum\Invoice;

enum Status: string
{
    case Exec = 'exec';
    case Save = 'save';
    case Deleted = 'deleted';
    case Closed = 'closed';
    case Archived = 'archived';
}
