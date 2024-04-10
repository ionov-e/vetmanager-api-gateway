<?php

namespace VetmanagerApiGateway\ActiveRecord\Admission;

use VetmanagerApiGateway\ActiveRecord\Breed\AbstractBreed;
use VetmanagerApiGateway\ActiveRecord\Client\ClientPlusTypeAndCity;
use VetmanagerApiGateway\ActiveRecord\ComboManualItem\ComboManualItemPlusComboManualName;
use VetmanagerApiGateway\ActiveRecord\Invoice\InvoiceOnly;
use VetmanagerApiGateway\ActiveRecord\Pet\PetPlusOwnerAndTypeAndBreedAndColor;
use VetmanagerApiGateway\ActiveRecord\PetType\AbstractPetType;
use VetmanagerApiGateway\ActiveRecord\User\UserPlusPositionAndRole;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\Admission\AdmissionOnlyDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInconsistencyException;
use VetmanagerApiGateway\Facade;

final class AdmissionOnly extends AbstractAdmission
{
    public static function getDtoClass(): string
    {
        return AdmissionOnlyDto::class;
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, AdmissionOnlyDto $modelDTO)
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
        try {
            return $this->getTypeId() ? (new Facade\ComboManualItem($this->activeRecordFactory))->getByAdmissionTypeId($this->getTypeId()) : null;
        } catch (VetmanagerApiGatewayInconsistencyException $e) {
            return null;
        }
    }

    /** @throws VetmanagerApiGatewayException */
    public function getClient(): ?ClientPlusTypeAndCity
    {
        return $this->getClientId() ? (new Facade\Client($this->activeRecordFactory))->getById($this->getClientId()) : null;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getPet(): ?PetPlusOwnerAndTypeAndBreedAndColor
    {
        return $this->getPetId() ? (new Facade\Pet($this->activeRecordFactory))->getById($this->getPetId()) : null;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getPetBreed(): ?AbstractBreed
    {
        return (new Facade\Pet($this->activeRecordFactory))->getById($this->getPetId())->getBreed();
    }

    /** @throws VetmanagerApiGatewayException */
    public function getPetType(): ?AbstractPetType
    {
        return (new Facade\Pet($this->activeRecordFactory))->getById($this->getPetId())->getPetType();
    }

    /** @return InvoiceOnly[]
     * @throws VetmanagerApiGatewayException
     */
    public function getInvoices(): array
    {
        return (new Facade\Admission($this->activeRecordFactory))->getById($this->getId())->getInvoices();
    }
}
