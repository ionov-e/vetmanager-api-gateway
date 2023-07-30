<?php

namespace VetmanagerApiGateway\ActiveRecord\Admission;

use VetmanagerApiGateway\ActiveRecord\Client\ClientOnly;
use VetmanagerApiGateway\ActiveRecord\ComboManualItem\ComboManualItemOnly;
use VetmanagerApiGateway\ActiveRecord\Invoice\InvoiceOnly;
use VetmanagerApiGateway\ActiveRecord\Pet\PetOnly;
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
        return $this->modelDTO->getClientDto() ? new ClientOnly($this->activeRecordFactory, $this->modelDTO->getClientDto()) : null;
    }

    public function getPet(): ?PetOnly
    {
        return $this->modelDTO->getPetDto() ? new PetOnly($this->activeRecordFactory, $this->modelDTO->getPetDto()) : null;
    }

    /** @return InvoiceOnly[] */
    public function getInvoices(): array
    {
        return $this->activeRecordFactory->getFromMultipleDtos($this->modelDTO->getInvoicesOnlyAsDtos(), InvoiceOnly::class);
    }
}
