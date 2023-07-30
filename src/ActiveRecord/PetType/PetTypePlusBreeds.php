<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\PetType;

use VetmanagerApiGateway\ActiveRecord\Breed\BreedOnly;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\PetType\PetTypeOnlyDto;
use VetmanagerApiGateway\DTO\PetType\PetTypePlusBreedsDto;

/**
 * @property-read PetTypeOnlyDto $originalDto
 * @property positive-int id
 * @property string title
 * @property string picture
 * @property string type
 * @property-read array{
 *     id: string,
 *     title: string,
 *     picture: string,
 *     type: ?string,
 *     breeds: list<array{
 *              id: string,
 *              title: string,
 *              pet_type_id: string
 *          }>
 * } $originalDataArray
 */
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
        return $this->activeRecordFactory->getFromMultipleDtos($this->modelDTO->getBreedsAsDtos(), BreedOnly::class);
    }
}
