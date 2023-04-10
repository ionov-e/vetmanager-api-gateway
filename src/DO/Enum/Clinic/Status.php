<?php

namespace VetmanagerApiGateway\DO\Enum\Clinic;

enum Status: string
{
    case Active = 'ACTIVE';
    case Deleted = 'DELETED';
}
