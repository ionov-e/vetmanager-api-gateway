<?php

namespace VetmanagerApiGateway\ActiveRecord\Admission;

use VetmanagerApiGateway\DTO\Admission\AdmissionPartialDto;

final class AdmissionPartial extends AbstractAdmission
{
    public static function getDtoClass(): string
    {
        return AdmissionPartialDto::class;
    }
}
