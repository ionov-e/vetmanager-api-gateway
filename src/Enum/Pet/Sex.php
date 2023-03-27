<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\Enum\Pet;

enum Sex: string
{
    case Male = 'male';
    case Female = 'female';
    case Castrated = 'castrated';
    case Sterilized = 'sterilized';
    case Unknown = 'unknown';
}
