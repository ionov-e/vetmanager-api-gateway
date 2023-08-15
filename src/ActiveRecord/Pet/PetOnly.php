<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Pet;

use VetmanagerApiGateway\ActiveRecord\Breed\AbstractBreed;
use VetmanagerApiGateway\ActiveRecord\Client\ClientPlusTypeAndCity;
use VetmanagerApiGateway\ActiveRecord\ComboManualItem\AbstractComboManualItem;
use VetmanagerApiGateway\ActiveRecord\PetType\PetTypePlusBreeds;
use VetmanagerApiGateway\DTO\Pet\PetOnlyDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade;

class PetOnly extends AbstractPet
{
    public static function getDtoClass(): string
    {
        return PetOnlyDto::class;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getOwner(): ClientPlusTypeAndCity
    {
        return (new Facade\Client($this->activeRecordFactory))->getById($this->getOwnerId());
    }

    /** @throws VetmanagerApiGatewayException */
    public function getPetType(): ?PetTypePlusBreeds
    {
        return $this->getPetTypeId()
            ? (new Facade\PetType($this->activeRecordFactory))->getById($this->getPetTypeId())
            : null;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getBreed(): ?AbstractBreed
    {
        return $this->getBreedId()
            ? (new Facade\Breed($this->activeRecordFactory))->getById($this->getBreedId())
            : null;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getColor(): ?AbstractComboManualItem
    {
        return $this->getColorId()
            ? (new Facade\ComboManualItem($this->activeRecordFactory))->getByPetColorId($this->getColorId())
            : null;
    }
}
