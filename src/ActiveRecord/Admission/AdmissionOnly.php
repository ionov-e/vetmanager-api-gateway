<?php

namespace VetmanagerApiGateway\ActiveRecord\Admission;

use VetmanagerApiGateway\DTO\Admission\AdmissionOnlyDto;

final class AdmissionOnly extends AbstractAdmission
{
    public static function getDtoClass(): string
    {
        return AdmissionOnlyDto::class;
    }
}
