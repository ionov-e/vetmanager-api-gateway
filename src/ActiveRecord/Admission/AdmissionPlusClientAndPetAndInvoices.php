<?php

namespace VetmanagerApiGateway\ActiveRecord\Admission;

use VetmanagerApiGateway\ActiveRecord\Client\ClientOnly;
use VetmanagerApiGateway\ActiveRecord\ComboManualItem\ComboManualItemPlusComboManualName;
use VetmanagerApiGateway\ActiveRecord\Invoice\InvoiceOnly;
use VetmanagerApiGateway\ActiveRecord\Pet\PetOnly;
use VetmanagerApiGateway\ActiveRecord\User\UserPlusPositionAndRole;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\Admission\AdmissionPlusClientAndPetAndInvoicesDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade;

final class AdmissionPlusClientAndPetAndInvoices extends AbstractAdmission
{
    public static function getDtoClass(): string
    {
        return AdmissionPlusClientAndPetAndInvoicesDto::class;
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, AdmissionPlusClientAndPetAndInvoicesDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->activeRecordFactory = $activeRecordFactory;
        $this->modelDTO = $modelDTO;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getUser(): ?UserPlusPositionAndRole
    {
        return $this->getUserId() ? (new Facade\User($this->activeRecordFactory))->getById($this->getUserId()) : null;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getAdmissionType(): ?ComboManualItemPlusComboManualName
    {
        return $this->getTypeId() ? (new Facade\ComboManualItem($this->activeRecordFactory))->getById($this->getTypeId()) : null;
    }

    public function getClient(): ?ClientOnly
    {
        return $this->modelDTO->getClientDto() ? new ClientOnly($this->activeRecordFactory, $this->modelDTO->getClientDto())  : null;
    }

    public function getPet(): ?PetOnly
    {
        return $this->modelDTO->getPetDto() ? new PetOnly($this->activeRecordFactory, $this->modelDTO->getPetDto())  : null;
    }

    /** @return InvoiceOnly[] */
    public function getInvoices(): array
    {
        return $this->activeRecordFactory->getFromMultipleDtos($this->modelDTO->getInvoicesOnlyAsDtos(), InvoiceOnly::class);
    }
}
