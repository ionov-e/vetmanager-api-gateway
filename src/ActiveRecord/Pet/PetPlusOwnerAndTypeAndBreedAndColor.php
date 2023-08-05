<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Pet;

use VetmanagerApiGateway\ActiveRecord\Breed\BreedOnly;
use VetmanagerApiGateway\ActiveRecord\Client\AbstractClient;
use VetmanagerApiGateway\ActiveRecord\Client\ClientOnly;
use VetmanagerApiGateway\ActiveRecord\ComboManualItem\ComboManualItemOnly;
use VetmanagerApiGateway\ActiveRecord\PetType\PetTypeOnly;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\Pet\PetPlusOwnerAndTypeAndBreedAndColorDto;

class PetPlusOwnerAndTypeAndBreedAndColor extends AbstractPet
{
    public static function getDtoClass(): string
    {
        return PetPlusOwnerAndTypeAndBreedAndColorDto::class;
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, PetPlusOwnerAndTypeAndBreedAndColorDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    public function getOwner(): AbstractClient
    {
        return new ClientOnly($this->activeRecordFactory, $this->modelDTO->getOwnerDto());
    }

    public function getPetType(): ?PetTypeOnly
    {
        return $this->modelDTO->getPetTypeDto() ? new PetTypeOnly($this->activeRecordFactory, $this->modelDTO->getPetTypeDto()) : null;
    }

    public function getBreed(): ?BreedOnly
    {
        return $this->modelDTO->getBreedDto() ? new BreedOnly($this->activeRecordFactory, $this->modelDTO->getBreedDto()) : null;
    }

    public function getColor(): ?ComboManualItemOnly
    {
        return $this->modelDTO->getColorDto() ? new ComboManualItemOnly($this->activeRecordFactory, $this->modelDTO->getColorDto()) : null;
    }
}
