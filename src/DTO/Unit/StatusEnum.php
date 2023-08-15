<?php

namespace VetmanagerApiGateway\DTO\Unit;

enum StatusEnum: string
{
    case Active = 'active';
    case Disabled = 'disabled';
}
