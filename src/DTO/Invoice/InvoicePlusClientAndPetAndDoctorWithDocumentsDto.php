<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Invoice;

use VetmanagerApiGateway\DTO\Client\ClientOnlyDto;
use VetmanagerApiGateway\DTO\InvoiceDocument\InvoiceDocumentOnlyDto;
use VetmanagerApiGateway\DTO\Pet\PetAdditionalPlusTypeAndBreedDto;
use VetmanagerApiGateway\DTO\User\UserOnlyDto;

class InvoicePlusClientAndPetAndDoctorWithDocumentsDto extends InvoicePlusClientAndPetAndDoctorDto
{
    /**
     * @param int|null $id
     * @param int|null $doctor_id
     * @param int|null $client_id
     * @param int|null $pet_id
     * @param string|null $description
     * @param string|null $percent
     * @param string|null $amount
     * @param string|null $status
     * @param string|null $invoice_date
     * @param string|null $old_id
     * @param int|null $night
     * @param string|null $increase
     * @param string|null $discount
     * @param int|null $call
     * @param string|null $paid_amount
     * @param string|null $create_date
     * @param string|null $payment_status
     * @param int|null $clinic_id
     * @param int|null $creator_id
     * @param int|null $fiscal_section_id
     * @param ClientOnlyDto $client
     * @param PetAdditionalPlusTypeAndBreedDto $pet
     * @param UserOnlyDto $doctor
     * @param InvoiceDocumentOnlyDto[] $invoiceDocuments
     */
    public function __construct(
        protected ?int          $id,
        protected ?int          $doctor_id,
        protected ?int          $client_id,
        protected ?int                             $pet_id,
        protected ?string                          $description,
        protected ?string                          $percent,
        protected ?string                          $amount,
        protected ?string                          $status,
        protected ?string                          $invoice_date,
        protected ?string                          $old_id,
        protected ?int                             $night,
        protected ?string                          $increase,
        protected ?string                          $discount,
        protected ?int                             $call,
        protected ?string                          $paid_amount,
        protected ?string                          $create_date,
        protected ?string                          $payment_status,
        protected ?int                             $clinic_id,
        protected ?int                             $creator_id,
        protected ?int                             $fiscal_section_id,
        protected ClientOnlyDto                    $client,
        protected PetAdditionalPlusTypeAndBreedDto $pet,
        protected UserOnlyDto                      $doctor,
        protected array                            $invoiceDocuments
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
            $fiscal_section_id,
            $client,
            $pet,
            $doctor
        );
    }

    /** @return InvoiceDocumentOnlyDto[] */
    public function getInvoiceDocumentsOnlyDtos(): array
    {
        return $this->invoiceDocuments;
    }
}
