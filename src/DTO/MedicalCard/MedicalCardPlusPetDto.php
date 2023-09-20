<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\MedicalCard;

use VetmanagerApiGateway\DTO\Pet\PetOnlyDto;

class MedicalCardPlusPetDto extends MedicalCardOnlyDto
{
    /**
     * @param int|null $id
     * @param int|null $patient_id
     * @param string|null $date_create
     * @param string|null $date_edit
     * @param string|null $diagnos
     * @param string|null $recomendation
     * @param string|null $invoice
     * @param int|null $admission_type
     * @param string|null $weight
     * @param string|null $temperature
     * @param int|null $meet_result_id
     * @param string|null $description
     * @param int|null $next_meet_id
     * @param int|null $doctor_id
     * @param int|null $creator_id
     * @param string|null $status
     * @param int|null $calling_id
     * @param int|null $admission_id
     * @param string|null $diagnos_text
     * @param string|null $diagnos_type_text
     * @param int|null $clinic_id
     * @param PetOnlyDto|null $patient
     */
    public function __construct(
        protected ?int    $id,
        protected ?int    $patient_id,
        protected ?string     $date_create,
        protected ?string     $date_edit,
        protected ?string     $diagnos,
        protected ?string     $recomendation,
        protected ?string     $invoice,
        protected ?int        $admission_type,
        protected ?string     $weight,
        protected ?string     $temperature,
        protected ?int        $meet_result_id,
        protected ?string     $description,
        protected ?int        $next_meet_id,
        protected ?int        $doctor_id,
        protected ?int        $creator_id,
        protected ?string     $status,
        protected ?int        $calling_id,
        protected ?int        $admission_id,
        protected ?string     $diagnos_text,
        protected ?string     $diagnos_type_text,
        protected ?int        $clinic_id,
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
