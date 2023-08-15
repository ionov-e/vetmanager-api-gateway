<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Breed;

use VetmanagerApiGateway\ActiveRecord\PetType\PetTypeOnly;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\Breed\BreedPlusPetTypeDto;

final class BreedPlusPetType extends AbstractBreed
{
    public static function getDtoClass(): string
    {
        return BreedPlusPetTypeDto::class;
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, BreedPlusPetTypeDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->activeRecordFactory = $activeRecordFactory;
        $this->modelDTO = $modelDTO;
    }

    public function getPetType(): PetTypeOnly
    {
        return new PetTypeOnly($this->activeRecordFactory, $this->modelDTO->getPetTypeDto());
    }
}
