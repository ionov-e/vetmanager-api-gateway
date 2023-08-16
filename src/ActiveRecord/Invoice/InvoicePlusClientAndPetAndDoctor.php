<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Invoice;

use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\ActiveRecord\Breed\AbstractBreed;
use VetmanagerApiGateway\ActiveRecord\Breed\BreedOnly;
use VetmanagerApiGateway\ActiveRecord\Client\AbstractClient;
use VetmanagerApiGateway\ActiveRecord\Client\ClientOnly;
use VetmanagerApiGateway\ActiveRecord\Pet\AbstractPet;
use VetmanagerApiGateway\ActiveRecord\Pet\PetOnly;
use VetmanagerApiGateway\ActiveRecord\PetType\AbstractPetType;
use VetmanagerApiGateway\ActiveRecord\User\AbstractUser;
use VetmanagerApiGateway\ActiveRecord\User\UserOnly;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\Invoice\InvoicePlusClientAndPetAndDoctorDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade;

final class InvoicePlusClientAndPetAndDoctor extends AbstractInvoice
{
    public static function getDtoClass(): string
    {
        return InvoicePlusClientAndPetAndDoctorDto::class;
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, InvoicePlusClientAndPetAndDoctorDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    /** Получить себя по ID, чтобы сразу получить за один запрос данные: Invoice Documents
     * @throws VetmanagerApiGatewayException
     */
    private function getFullSelf(): InvoicePlusClientAndPetAndDoctorAndDocuments
    {
        return (new Facade\Invoice($this->activeRecordFactory))->getById($this->getId());
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

    /** @inheritDoc
     * @throws VetmanagerApiGatewayException
     */
    public function getInvoiceDocuments(): array
    {
        return $this->getFullSelf()->getInvoiceDocuments();
    }
}
