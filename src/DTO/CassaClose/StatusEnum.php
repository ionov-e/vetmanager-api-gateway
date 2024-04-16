<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\CassaClose;

enum StatusEnum: string
{
    case Exec = 'exec';
    case Save = 'save';
    case Deleted = 'deleted';
}
