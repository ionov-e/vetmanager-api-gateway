<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Breed;

use VetmanagerApiGateway\DTO\PetType\PetTypeOnlyDto;

final class BreedPlusPetTypeDto extends BreedOnlyDto
{
    /**
     * @param int|null $id
     * @param string|null $title
     * @param int|null $pet_type_id
     * @param PetTypeOnlyDto $petType
     */
    public function __construct(
        public ?int           $id,
        public ?string        $title,
        public ?int           $pet_type_id,
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
