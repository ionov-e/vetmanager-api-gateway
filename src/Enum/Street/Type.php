<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\Enum\Street;

enum Type: string
{
    case Street = 'street';
    case Bulvar = 'bulvar';
    case Pereulok = 'pereulok';
    case Prospect = 'prospect';
    case Proezd = 'proezd';
    case DeadEnd = 'dead_end';
    case Highway = 'highway';
    case Embankment = 'embankment';
    case Square = 'square';
    case Microdistrict = 'microdistrict';
}
