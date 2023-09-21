<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Pet;

use VetmanagerApiGateway\DTO\Breed\BreedOnlyDto;
use VetmanagerApiGateway\DTO\Client\ClientOnlyDto;
use VetmanagerApiGateway\DTO\ComboManualItem\ComboManualItemOnlyDto;
use VetmanagerApiGateway\DTO\PetType\PetTypeOnlyDto;

class PetPlusOwnerAndTypeAndBreedAndColorDto extends PetOnlyDto
{
    /**
     * @param int|string|null $id
     * @param int|string|null $owner_id
     * @param int|string|null $type_id
     * @param string|null $alias
     * @param string|null $sex
     * @param string|null $date_register
     * @param string|null $birthday
     * @param string|null $note
     * @param int|string|null $breed_id
     * @param int|string|null $old_id
     * @param int|string|null $color_id
     * @param string|null $deathnote
     * @param string|null $deathdate
     * @param string|null $chip_number
     * @param string|null $lab_number
     * @param string|null $status
     * @param string|null $picture
     * @param string|null $weight
     * @param string|null $edit_date
     * @param ClientOnlyDto $owner
     * @param PetTypeOnlyDto|null $type
     * @param BreedOnlyDto|null $breed
     * @param ComboManualItemOnlyDto|null $color
     */
    public function __construct(
        protected int|string|null $id,
        protected int|string|null $owner_id,
        protected int|string|null $type_id,
        protected ?string         $alias,
        protected ?string         $sex,
        protected ?string         $date_register,
        protected ?string         $birthday,
        protected ?string         $note,
        protected int|string|null $breed_id,
        protected int|string|null $old_id,
        protected int|string|null $color_id,
        protected ?string         $deathnote,
        protected ?string         $deathdate,
        protected ?string         $chip_number,
        protected ?string         $lab_number,
        protected ?string         $status,
        protected ?string         $picture,
        protected ?string         $weight,
        protected ?string         $edit_date,
        protected ClientOnlyDto   $owner,
        protected ?PetTypeOnlyDto $type = null,
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
