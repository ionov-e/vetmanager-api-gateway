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
     * @param int|string|null $id
     * @param int|string|null $doctor_id
     * @param int|string|null $client_id
     * @param int|string|null $pet_id
     * @param string|null $description
     * @param string|null $percent
     * @param string|null $amount
     * @param string|null $status
     * @param string|null $invoice_date
     * @param string|null $old_id
     * @param int|string|null $night
     * @param string|null $increase
     * @param string|null $discount
     * @param int|string|null $call
     * @param string|null $paid_amount
     * @param string|null $create_date
     * @param string|null $payment_status
     * @param int|string|null $clinic_id
     * @param int|string|null $creator_id
     * @param int|string|null $fiscal_section_id
     * @param ClientOnlyDto $client
     * @param PetAdditionalPlusTypeAndBreedDto $pet
     * @param UserOnlyDto $doctor
     * @param InvoiceDocumentOnlyDto[] $invoiceDocuments
     */
    public function __construct(
        protected int|string|null $id,
        protected int|string|null $doctor_id,
        protected int|string|null $client_id,
        protected int|string|null $pet_id,
        protected ?string                          $description,
        protected ?string                          $percent,
        protected ?string                          $amount,
        protected ?string                          $status,
        protected ?string                          $invoice_date,
        protected ?string                          $old_id,
        protected int|string|null $night,
        protected ?string                          $increase,
        protected ?string                          $discount,
        protected int|string|null $call,
        protected ?string                          $paid_amount,
        protected ?string                          $create_date,
        protected ?string                          $payment_status,
        protected int|string|null $clinic_id,
        protected int|string|null $creator_id,
        protected int|string|null $fiscal_section_id,
        protected ClientOnlyDto                    $client,
        protected PetAdditionalPlusTypeAndBreedDto $pet,
        protected UserOnlyDto                      $doctor,
        protected array                            $invoiceDocuments
    ) {
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
