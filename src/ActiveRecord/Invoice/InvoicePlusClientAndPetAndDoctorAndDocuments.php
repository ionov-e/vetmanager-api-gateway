<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Invoice;

use VetmanagerApiGateway\ActiveRecord\Breed\AbstractBreed;
use VetmanagerApiGateway\ActiveRecord\Client\AbstractClient;
use VetmanagerApiGateway\ActiveRecord\Pet\AbstractPet;
use VetmanagerApiGateway\ActiveRecord\PetType\AbstractPetType;
use VetmanagerApiGateway\ActiveRecord\User\AbstractUser;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\Breed\BreedOnlyDto;
use VetmanagerApiGateway\DTO\Client\ClientOnlyDto;
use VetmanagerApiGateway\DTO\Invoice\InvoicePlusClientAndPetAndDoctorWithDocumentsDto;
use VetmanagerApiGateway\DTO\InvoiceDocument\InvoiceDocumentOnlyDto;
use VetmanagerApiGateway\DTO\Pet\PetOnlyDto;
use VetmanagerApiGateway\DTO\PetType\PetTypeOnlyDto;
use VetmanagerApiGateway\DTO\User\UserOnlyDto;

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
        return $this->activeRecordFactory->getFromSingleDto($this->modelDTO->getClientOnlyDto(), ClientOnlyDto::class);
    }

    public function getPet(): AbstractPet
    {
        return $this->activeRecordFactory->getFromSingleDto($this->modelDTO->getPetAdditionalPlusTypeAndBreedDto(), PetOnlyDto::class);
    }

    public function getPetBreed(): ?AbstractBreed
    {
        $dto = $this->modelDTO->getPetAdditionalPlusTypeAndBreedDto()->getPetTypeOnlyDto();
        return $dto ? $this->activeRecordFactory->getFromSingleDto($dto, BreedOnlyDto::class) : null;
    }

    public function getPetType(): ?AbstractPetType
    {
        $dto = $this->modelDTO->getPetAdditionalPlusTypeAndBreedDto()->getPetTypeOnlyDto();
        return $dto ? $this->activeRecordFactory->getFromSingleDto($dto, PetTypeOnlyDto::class) : null;
    }

    public function getUser(): AbstractUser
    {
        return $this->activeRecordFactory->getFromSingleDto($this->modelDTO->getUserOnlyDto(), UserOnlyDto::class);
    }

    /** @inheritDoc */
    public function getInvoiceDocuments(): array
    {
        return $this->activeRecordFactory->getFromMultipleDtos($this->modelDTO->getInvoiceDocumentsOnlyDtos(), InvoiceDocumentOnlyDto::class);
    }
}
