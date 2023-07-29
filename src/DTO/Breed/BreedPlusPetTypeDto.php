<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Breed;

use VetmanagerApiGateway\DTO\PetType\PetTypeOnlyDto;

final class BreedPlusPetTypeDto extends BreedOnlyDto
{
    public function __construct(
        public ?string         $id,
        public ?string         $title,
        public ?string         $pet_type_id,
        public PetTypeOnlyDto $petType
    )
    {
        parent::__construct(
            $id,
            $title,
            $pet_type_id,
        );
    }

    public function getPetTypeDto(): PetTypeOnlyDto
    {
        return $this->petType;
    }
}
