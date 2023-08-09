<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Invoice;

use VetmanagerApiGateway\ActiveRecord\Breed\AbstractBreed;
use VetmanagerApiGateway\ActiveRecord\Client\AbstractClient;
use VetmanagerApiGateway\ActiveRecord\Pet\AbstractPet;
use VetmanagerApiGateway\ActiveRecord\PetType\AbstractPetType;
use VetmanagerApiGateway\ActiveRecord\User\AbstractUser;
use VetmanagerApiGateway\DTO\Invoice\InvoiceOnlyDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade;


class InvoiceOnly extends AbstractInvoice
{
    public static function getDtoClass(): string
    {
        return InvoiceOnlyDto::class;
    }

    /** Получить себя по ID, чтобы сразу получить за один запрос данные:
     * Client, Pet, Breed, Pet Type, User, Invoice Documents
     * @throws VetmanagerApiGatewayException
     */
    public function getFullSelf(): InvoicePlusClientAndPetAndDoctorAndDocuments
    {
        return (new Facade\Invoice($this->activeRecordFactory))->getById($this->getId());
    }

    /** @throws VetmanagerApiGatewayException */
    public function getClient(): AbstractClient
    {
        return (new Facade\Client($this->activeRecordFactory))->getById($this->getClientId());
    }

    /** @throws VetmanagerApiGatewayException */
    public function getPet(): AbstractPet
    {
        return (new Facade\Pet($this->activeRecordFactory))->getById($this->getPetId());
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

    /** @throws VetmanagerApiGatewayException */
    public function getUser(): AbstractUser
    {
        return (new Facade\User($this->activeRecordFactory))->getById($this->getUserId());
    }

    /** @inheritDoc
     * @throws VetmanagerApiGatewayException
     */
    public function getInvoiceDocuments(): array
    {
        return $this->getFullSelf()->getInvoiceDocuments();
    }
}
