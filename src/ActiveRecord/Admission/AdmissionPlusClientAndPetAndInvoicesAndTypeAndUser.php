<?php

namespace VetmanagerApiGateway\ActiveRecord\Admission;

use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\ActiveRecord\Breed\AbstractBreed;
use VetmanagerApiGateway\ActiveRecord\Breed\BreedOnly;
use VetmanagerApiGateway\ActiveRecord\Client\ClientOnly;
use VetmanagerApiGateway\ActiveRecord\ComboManualItem\ComboManualItemOnly;
use VetmanagerApiGateway\ActiveRecord\Invoice\InvoiceOnly;
use VetmanagerApiGateway\ActiveRecord\Pet\PetOnly;
use VetmanagerApiGateway\ActiveRecord\PetType\AbstractPetType;
use VetmanagerApiGateway\ActiveRecord\User\UserOnly;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\Admission\AdmissionPlusClientAndPetAndInvoicesAndTypeAndUserDto;

final class AdmissionPlusClientAndPetAndInvoicesAndTypeAndUser extends AbstractAdmission
{
    public static function getDtoClass(): string
    {
        return AdmissionPlusClientAndPetAndInvoicesAndTypeAndUserDto::class;
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, AdmissionPlusClientAndPetAndInvoicesAndTypeAndUserDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->activeRecordFactory = $activeRecordFactory;
        $this->modelDTO = $modelDTO;
    }

    public function getUser(): ?UserOnly
    {
        return $this->modelDTO->getUserDto() ? new UserOnly($this->activeRecordFactory, $this->modelDTO->getUserDto()) : null;
    }

    public function getAdmissionType(): ?ComboManualItemOnly
    {
        return $this->modelDTO->getAdmissionTypeDto() ? new ComboManualItemOnly($this->activeRecordFactory, $this->modelDTO->getAdmissionTypeDto()) : null;
    }

    public function getClient(): ?ClientOnly
    {
        return $this->modelDTO->getClientOnlyDto() ? new ClientOnly($this->activeRecordFactory, $this->modelDTO->getClientOnlyDto()) : null;
    }

    public function getPet(): ?PetOnly
    {
        return $this->modelDTO->getPetAdditionalPlusTypeAndBreedDto()
            ? new PetOnly($this->activeRecordFactory, $this->modelDTO->getPetAdditionalPlusTypeAndBreedDto())
            : null;
    }

    public function getPetBreed(): ?AbstractBreed
    {
        $dto = $this->modelDTO->getPetAdditionalPlusTypeAndBreedDto()->getBreedOnlyDto();
        return $dto ? $this->activeRecordFactory->getFromSingleDto($dto, BreedOnly::class) : null;
    }

    public function getPetType(): ?AbstractPetType
    {
        $dto = $this->modelDTO->getPetAdditionalPlusTypeAndBreedDto()->getPetTypeOnlyDto();
        return $dto ? $this->activeRecordFactory->getFromSingleDto($dto, ActiveRecord\PetType\PetTypeOnly::class) : null;
    }

    /** @return InvoiceOnly[] */
    public function getInvoices(): array
    {
        return $this->activeRecordFactory->getFromMultipleDtos($this->modelDTO->getInvoicesOnlyDtos(), InvoiceOnly::class);
    }
}
