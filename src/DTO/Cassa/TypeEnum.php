<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Cassa;

enum TypeEnum: string
{
    case Bank = 'bank';
    case Safe = 'safe';
    case Operating = 'operating';
}
