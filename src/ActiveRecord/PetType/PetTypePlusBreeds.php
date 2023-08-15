<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\PetType;

use VetmanagerApiGateway\ActiveRecord\Breed\BreedOnly;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\PetType\PetTypePlusBreedsDto;

final class PetTypePlusBreeds extends AbstractPetType
{
    public static function getDtoClass(): string
    {
        return PetTypePlusBreedsDto::class;
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, PetTypePlusBreedsDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    /** @return BreedOnly[] */
    public function getBreeds(): array
    {
        return $this->activeRecordFactory->getFromMultipleDtos($this->modelDTO->getBreedsOnlyDtos(), BreedOnly::class);
    }
}
