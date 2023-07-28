<?php

namespace VetmanagerApiGateway\DTO\MedicalCard;

enum StatusEnum: string
{
    case Active = 'active';
    case Deleted = 'deleted';
    case Archived = 'archived';
}
