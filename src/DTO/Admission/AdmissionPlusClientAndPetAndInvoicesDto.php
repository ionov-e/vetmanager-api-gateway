<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Admission;

use VetmanagerApiGateway\DTO\Client\ClientOnlyDto;
use VetmanagerApiGateway\DTO\Invoice\InvoiceOnlyDto;
use VetmanagerApiGateway\DTO\Pet\PetOnlyDto;

class AdmissionPlusClientAndPetAndInvoicesDto extends AdmissionOnlyDto
{
    /**
     * @param InvoiceOnlyDto[] $invoices
     */
    public function __construct(
        protected ?string        $id,
        protected ?string        $admission_date,
        protected ?string        $description,
        protected ?string        $client_id,
        protected ?string        $patient_id,
        protected ?string        $user_id,
        protected ?string        $type_id,
        protected ?string        $admission_length,
        protected ?string        $status,
        protected ?string        $clinic_id,
        protected ?string        $direct_direction,
        protected ?string        $creator_id,
        protected ?string        $create_date,
        protected ?string        $escorter_id,
        protected ?string        $reception_write_channel,
        protected ?string        $is_auto_create,
        protected ?string        $invoices_sum,
        protected ?ClientOnlyDto $client = null,
        protected ?PetOnlyDto    $pet = null,
        protected array          $invoices = []
    )
    {
        parent::__construct(
            $id,
            $admission_date,
            $description,
            $client_id,
            $patient_id,
            $user_id,
            $type_id,
            $admission_length,
            $status,
            $clinic_id,
            $direct_direction,
            $creator_id,
            $create_date,
            $escorter_id,
            $reception_write_channel,
            $is_auto_create,
            $invoices_sum,
        );
    }

    /** @return InvoiceOnlyDto[] */
    public function getInvoiceDtos(): array
    {
        return $this->invoices;
    }

    public function getClientDto(): ?ClientOnlyDto
    {
        return $this->client;
    }

    public function getPetDto(): ?PetOnlyDto
    {
        return $this->pet;
    }
}
