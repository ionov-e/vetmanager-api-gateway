<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Admission;

enum StatusEnum: string
{
    case Save = 'save';
    case Directed = 'directed';
    case Accepted = 'accepted';
    case Deleted = 'deleted';
    case Delayed = 'delayed';
    case NotApproved = 'not_approved';
    case InTreatment = 'in_treatment';
    case NotConfirmed = 'not_confirmed';
}
