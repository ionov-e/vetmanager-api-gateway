<?php declare(strict_types=1);

namespace VetmanagerApiGateway\Enum\Pet;

enum Status: string
{
    case Alive = 'alive';
    case Dead = 'dead';
    case Deleted = 'deleted';
}
