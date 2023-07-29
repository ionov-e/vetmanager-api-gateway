<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\PetType;

use VetmanagerApiGateway\DTO\Breed\BreedOnlyDto;

class PetTypePlusBreedsDto extends PetTypeOnlyDto
{
    public function __construct(
        public ?string $id,
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
    public function getBreedsDtos(): array
    {
        return $this->breeds;
    }
}
