<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Pet;

enum StatusEnum: string
{
    case Alive = 'alive';
    case Dead = 'dead';
    case Deleted = 'deleted';
}
