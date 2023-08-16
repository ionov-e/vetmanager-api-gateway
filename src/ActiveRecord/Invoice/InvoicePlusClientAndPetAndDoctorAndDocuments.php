<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Invoice;

use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\ActiveRecord\Breed\AbstractBreed;
use VetmanagerApiGateway\ActiveRecord\Breed\BreedOnly;
use VetmanagerApiGateway\ActiveRecord\Client\AbstractClient;
use VetmanagerApiGateway\ActiveRecord\Client\ClientOnly;
use VetmanagerApiGateway\ActiveRecord\InvoiceDocument\InvoiceDocumentOnly;
use VetmanagerApiGateway\ActiveRecord\Pet\AbstractPet;
use VetmanagerApiGateway\ActiveRecord\Pet\PetOnly;
use VetmanagerApiGateway\ActiveRecord\PetType\AbstractPetType;
use VetmanagerApiGateway\ActiveRecord\User\AbstractUser;
use VetmanagerApiGateway\ActiveRecord\User\UserOnly;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\Invoice\InvoicePlusClientAndPetAndDoctorWithDocumentsDto;

final class InvoicePlusClientAndPetAndDoctorAndDocuments extends AbstractInvoice

{
    public static function getDtoClass(): string
    {
        return InvoicePlusClientAndPetAndDoctorWithDocumentsDto::class;
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, InvoicePlusClientAndPetAndDoctorWithDocumentsDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    public function getClient(): AbstractClient
    {
        return $this->activeRecordFactory->getFromSingleDto($this->modelDTO->getClientOnlyDto(), ClientOnly::class);
    }

    public function getPet(): AbstractPet
    {
        return $this->activeRecordFactory->getFromSingleDto($this->modelDTO->getPetAdditionalPlusTypeAndBreedDto(), PetOnly::class);
    }

    public function getPetBreed(): ?AbstractBreed
    {
        $dto = $this->modelDTO->getPetAdditionalPlusTypeAndBreedDto()->getPetTypeOnlyDto();
        return $dto ? $this->activeRecordFactory->getFromSingleDto($dto, BreedOnly::class) : null;
    }

    public function getPetType(): ?AbstractPetType
    {
        $dto = $this->modelDTO->getPetAdditionalPlusTypeAndBreedDto()->getPetTypeOnlyDto();
        return $dto ? $this->activeRecordFactory->getFromSingleDto($dto, ActiveRecord\PetType\PetTypeOnly::class) : null;
    }

    public function getUser(): AbstractUser
    {
        return $this->activeRecordFactory->getFromSingleDto($this->modelDTO->getUserOnlyDto(), UserOnly::class);
    }

    /** @inheritDoc */
    public function getInvoiceDocuments(): array
    {
        return $this->activeRecordFactory->getFromMultipleDtos($this->modelDTO->getInvoiceDocumentsOnlyDtos(), InvoiceDocumentOnly::class);
    }
}
