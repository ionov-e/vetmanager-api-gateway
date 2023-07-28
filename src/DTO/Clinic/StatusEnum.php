<?php

namespace VetmanagerApiGateway\DTO\Clinic;

enum StatusEnum: string
{
    case Active = 'ACTIVE';
    case Deleted = 'DELETED';
}
