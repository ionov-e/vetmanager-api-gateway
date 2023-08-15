<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\MedicalCard;

use VetmanagerApiGateway\DTO\Pet\PetOnlyDto;

class MedicalCardPlusPetDto extends MedicalCardOnlyDto
{
    /**
     * @param string|null $id
     * @param string|null $patient_id
     * @param string|null $date_create
     * @param string|null $date_edit
     * @param string|null $diagnos
     * @param string|null $recomendation
     * @param string|null $invoice
     * @param string|null $admission_type
     * @param string|null $weight
     * @param string|null $temperature
     * @param string|null $meet_result_id
     * @param string|null $description
     * @param string|null $next_meet_id
     * @param string|null $doctor_id
     * @param string|null $creator_id
     * @param string|null $status
     * @param string|null $calling_id
     * @param string|null $admission_id
     * @param string|null $diagnos_text
     * @param string|null $diagnos_type_text
     * @param string|null $clinic_id
     * @param PetOnlyDto|null $patient
     */
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
