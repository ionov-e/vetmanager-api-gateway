<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Pet;

use VetmanagerApiGateway\DTO\Breed\BreedOnlyDto;
use VetmanagerApiGateway\DTO\Client\ClientOnlyDto;
use VetmanagerApiGateway\DTO\ComboManualItem\ComboManualItemOnlyDto;
use VetmanagerApiGateway\DTO\PetType\PetTypeOnlyDto;

class PetPlusOwnerAndTypeAndBreedAndColorDto extends PetOnlyDto
{
    public function __construct(
        protected ?string                 $id,
        protected ?string                 $owner_id,
        protected ?string                 $type_id,
        protected ?string                 $alias,
        protected ?string                 $sex,
        protected ?string                 $date_register,
        protected ?string                 $birthday,
        protected ?string                 $note,
        protected ?string                 $breed_id,
        protected ?string                 $old_id,
        protected ?string                 $color_id,
        protected ?string                 $deathnote,
        protected ?string                 $deathdate,
        protected ?string                 $chip_number,
        protected ?string                 $lab_number,
        protected ?string                 $status,
        protected ?string                 $picture,
        protected ?string                 $weight,
        protected ?string                 $edit_date,
        protected ClientOnlyDto           $owner,
        protected ?PetTypeOnlyDto         $type = null,
        protected ?BreedOnlyDto           $breed = null,
        protected ?ComboManualItemOnlyDto $color = null
    )
    {
        parent::__construct(
            $id,
            $owner_id,
            $type_id,
            $alias,
            $sex,
            $date_register,
            $birthday,
            $note,
            $breed_id,
            $old_id,
            $color_id,
            $deathnote,
            $deathdate,
            $chip_number,
            $lab_number,
            $status,
            $picture,
            $weight,
            $edit_date
        );
    }

    public function getOwnerDto(): ClientOnlyDto
    {
        return $this->owner;
    }

    public function getPetTypeDto(): ?PetTypeOnlyDto
    {
        return $this->type;
    }

    public function getBreedDto(): ?BreedOnlyDto
    {
        return $this->breed;
    }

    public function getColorDto(): ?ComboManualItemOnlyDto
    {
        return $this->color;
    }
}
