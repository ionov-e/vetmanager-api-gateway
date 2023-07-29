<?php

namespace VetmanagerApiGateway\ActiveRecord\Admission;

use VetmanagerApiGateway\ActiveRecord\Client\ClientPlusTypeAndCity;
use VetmanagerApiGateway\ActiveRecord\ComboManualItem\ComboManualItemPlusComboManualName;
use VetmanagerApiGateway\ActiveRecord\Invoice\InvoiceOnly;
use VetmanagerApiGateway\ActiveRecord\Pet\PetPlusOwnerAndTypeAndBreedAndColor;
use VetmanagerApiGateway\ActiveRecord\User\UserPlusPositionAndRole;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\Admission\AdmissionOnlyDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
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
        return $this->getTypeId() ? (new Facade\ComboManualItem($this->activeRecordFactory))->getById($this->getTypeId()) : null;
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

    /** @return InvoiceOnly[]
     * @throws VetmanagerApiGatewayException
     */
    public function getInvoices(): array
    {
        return (new Facade\Admission($this->activeRecordFactory))->getById($this->getId())->getInvoices();
    }
}
