<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Invoice;

use VetmanagerApiGateway\DTO\Client\ClientOnlyDto;
use VetmanagerApiGateway\DTO\Pet\PetAdditionalPlusTypeAndBreedDto;
use VetmanagerApiGateway\DTO\User\UserOnlyDto;

class InvoicePlusClientAndPetAndDoctorDto extends InvoiceOnlyDto
{
    /**
     * @param string|null $id
     * @param string|null $doctor_id
     * @param string|null $client_id
     * @param string|null $pet_id
     * @param string|null $description
     * @param string|null $percent
     * @param string|null $amount
     * @param string|null $status
     * @param string|null $invoice_date
     * @param string|null $old_id
     * @param string|null $night
     * @param string|null $increase
     * @param string|null $discount
     * @param string|null $call
     * @param string|null $paid_amount
     * @param string|null $create_date
     * @param string|null $payment_status
     * @param string|null $clinic_id
     * @param string|null $creator_id
     * @param string|null $fiscal_section_id
     * @param ClientOnlyDto $client
     * @param PetAdditionalPlusTypeAndBreedDto $pet
     * @param UserOnlyDto $doctor
     */
    public function __construct(
        protected ?string                          $id,
        protected ?string                          $doctor_id,
        protected ?string                          $client_id,
        protected ?string                          $pet_id,
        protected ?string                          $description,
        protected ?string                          $percent,
        protected ?string                          $amount,
        protected ?string                          $status,
        protected ?string                          $invoice_date,
        protected ?string                          $old_id,
        protected ?string                          $night,
        protected ?string                          $increase,
        protected ?string                          $discount,
        protected ?string                          $call,
        protected ?string                          $paid_amount,
        protected ?string                          $create_date,
        protected ?string                          $payment_status,
        protected ?string                          $clinic_id,
        protected ?string                          $creator_id,
        protected ?string                          $fiscal_section_id,
        protected ClientOnlyDto                    $client,
        protected PetAdditionalPlusTypeAndBreedDto $pet,
        protected UserOnlyDto                      $doctor
    )
    {
        parent::__construct(
            $id,
            $doctor_id,
            $client_id,
            $pet_id,
            $description,
            $percent,
            $amount,
            $status,
            $invoice_date,
            $old_id,
            $night,
            $increase,
            $discount,
            $call,
            $paid_amount,
            $create_date,
            $payment_status,
            $clinic_id,
            $creator_id,
            $fiscal_section_id
        );
    }

    public function getClientOnlyDto(): ClientOnlyDto
    {
        return $this->client;
    }

    public function getPetAdditionalPlusTypeAndBreedDto(): PetAdditionalPlusTypeAndBreedDto
    {
        return $this->pet;
    }

    public function getUserOnlyDto(): UserOnlyDto
    {
        return $this->doctor;
    }
}
