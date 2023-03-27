<?php

namespace VetmanagerApiGateway\Enum\MedicalCard;

enum Status: string
{
    case Active = 'active';
    case Deleted = 'deleted';
    case Archived = 'archived';
}
