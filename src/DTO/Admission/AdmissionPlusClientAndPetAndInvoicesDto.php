<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Admission;

use VetmanagerApiGateway\DTO\Client\ClientOnlyDto;
use VetmanagerApiGateway\DTO\Invoice\InvoiceOnlyDto;
use VetmanagerApiGateway\DTO\Pet\PetAdditionalPlusTypeAndBreedDto;

class AdmissionPlusClientAndPetAndInvoicesDto extends AdmissionOnlyDto
{
    /**
     * @param int|string|null $id
     * @param string|null $admission_date
     * @param string|null $description
     * @param int|string|null $client_id
     * @param int|string|null $patient_id
     * @param int|string|null $user_id
     * @param int|string|null $type_id
     * @param string|null $admission_length
     * @param string|null $status
     * @param int|string|null $clinic_id
     * @param int|string|null $direct_direction
     * @param int|string|null $creator_id
     * @param string|null $create_date
     * @param int|string|null $escorter_id
     * @param string|null $reception_write_channel
     * @param int|string|null $is_auto_create
     * @param string|null $invoices_sum
     * @param ClientOnlyDto|null $client
     * @param PetAdditionalPlusTypeAndBreedDto|null $pet
     * @param InvoiceOnlyDto[] $invoices
     */
    public function __construct(
        protected int|string|null $id,
        protected ?string         $admission_date,
        protected ?string         $description,
        protected int|string|null $client_id,
        protected int|string|null $patient_id,
        protected int|string|null $user_id,
        protected int|string|null $type_id,
        protected ?string         $admission_length,
        protected ?string         $status,
        protected int|string|null $clinic_id,
        protected int|string|null $direct_direction,
        protected int|string|null $creator_id,
        protected ?string         $create_date,
        protected int|string|null $escorter_id,
        protected ?string         $reception_write_channel,
        protected int|string|null $is_auto_create,
        protected ?string         $invoices_sum,
        protected ?ClientOnlyDto                    $client = null,
        protected ?PetAdditionalPlusTypeAndBreedDto $pet = null,
        protected array                             $invoices = []
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
    public function getInvoicesOnlyDtos(): array
    {
        return $this->invoices;
    }

    public function getClientOnlyDto(): ?ClientOnlyDto
    {
        return $this->client;
    }

    public function getPetAdditionalPlusTypeAndBreedDto(): ?PetAdditionalPlusTypeAndBreedDto
    {
        return $this->pet;
    }
}
