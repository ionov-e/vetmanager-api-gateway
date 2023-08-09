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
use VetmanagerApiGateway\DTO\Invoice\InvoicePlusClientAndPetAndDoctorDto;
use VetmanagerApiGateway\DTO\Pet\PetOnlyDto;
use VetmanagerApiGateway\DTO\PetType\PetTypeOnlyDto;
use VetmanagerApiGateway\DTO\User\UserOnlyDto;
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
        return $this->activeRecordFactory->getFromSingleDto($this->modelDTO->getClientOnlyDto(), ClientOnlyDto::class);
    }

    public function getPet(): AbstractPet
    {
        return $this->activeRecordFactory->getFromSingleDto($this->modelDTO->getPetAdditionalPlusTypeAndBreedDto(), PetOnlyDto::class);
    }

    public function getPetBreed(): ?AbstractBreed
    {
        $dto = $this->modelDTO->getPetAdditionalPlusTypeAndBreedDto()->getPetTypeDto();
        return $dto ? $this->activeRecordFactory->getFromSingleDto($dto, BreedOnlyDto::class) : null;
    }

    public function getPetType(): ?AbstractPetType
    {
        $dto = $this->modelDTO->getPetAdditionalPlusTypeAndBreedDto()->getPetTypeDto();
        return $dto ? $this->activeRecordFactory->getFromSingleDto($dto, PetTypeOnlyDto::class) : null;
    }

    public function getUser(): AbstractUser
    {
        return $this->activeRecordFactory->getFromSingleDto($this->modelDTO->getUserOnlyDto(), UserOnlyDto::class);
    }

    /** @inheritDoc
     * @throws VetmanagerApiGatewayException
     */
    public function getInvoiceDocuments(): array
    {
        return $this->getFullSelf()->getInvoiceDocuments();
    }
}
