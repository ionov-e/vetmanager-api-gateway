<?php

namespace VetmanagerApiGateway\DTO\Enum\Clinic;

enum Status: string
{
    case Active = 'ACTIVE';
    case Deleted = 'DELETED';
}
