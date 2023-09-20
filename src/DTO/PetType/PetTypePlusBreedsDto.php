<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\PetType;

use VetmanagerApiGateway\DTO\Breed\BreedOnlyDto;

class PetTypePlusBreedsDto extends PetTypeOnlyDto
{
    /**
     * @param int|null $id
     * @param string|null $title
     * @param string|null $picture
     * @param string|null $type
     * @param BreedOnlyDto[] $breeds
     */
    public function __construct(
        public ?int    $id,
        public ?string $title,
        public ?string $picture,
        public ?string $type,
        public array   $breeds,
    )
    {
        parent::__construct(
            $id,
            $title,
            $picture,
            $type
        );
    }

    /** @return BreedOnlyDto[] */
    public function getBreedsOnlyDtos(): array
    {
        return $this->breeds;
    }
}
