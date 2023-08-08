<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\MedicalCard;

use VetmanagerApiGateway\DTO\Pet\PetOnlyDto;

class MedicalCardPlusPetDto extends MedicalCardOnlyDto
{
    public function __construct(
        protected ?string     $id,
        protected ?string     $patient_id,
        protected ?string     $date_create,
        protected ?string     $date_edit,
        protected ?string     $diagnos,
        protected ?string     $recomendation,
        protected ?string     $invoice,
        protected ?string     $admission_type,
        protected ?string     $weight,
        protected ?string     $temperature,
        protected ?string     $meet_result_id,
        protected ?string     $description,
        protected ?string     $next_meet_id,
        protected ?string     $doctor_id,
        protected ?string     $creator_id,
        protected ?string     $status,
        protected ?string     $calling_id,
        protected ?string     $admission_id,
        protected ?string     $diagnos_text,
        protected ?string     $diagnos_type_text,
        protected ?string     $clinic_id,
        protected ?PetOnlyDto $patient
    )
    {
        parent::__construct(
            $id,
            $patient_id,
            $date_create,
            $date_edit,
            $diagnos,
            $recomendation,
            $invoice,
            $admission_type,
            $weight,
            $temperature,
            $meet_result_id,
            $description,
            $next_meet_id,
            $doctor_id,
            $creator_id,
            $status,
            $calling_id,
            $admission_id,
            $diagnos_text,
            $diagnos_type_text,
            $clinic_id
        );
    }

    public function getPetOnlyDto(): ?PetOnlyDto
    {
        return $this->patient;
    }
}
