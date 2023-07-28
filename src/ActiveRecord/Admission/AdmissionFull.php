<?php

namespace VetmanagerApiGateway\ActiveRecord\Admission;

final class AdmissionFull extends AbstractAdmission
{
    public static function getDtoClass(): string
    {
        return AdmissionFullDto::class;
    }

}
