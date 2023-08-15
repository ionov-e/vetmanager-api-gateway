<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Invoice;

enum StatusEnum: string
{
    case Exec = 'exec';
    case Save = 'save';
    case Deleted = 'deleted';
    case Closed = 'closed';
    case Archived = 'archived';
}
