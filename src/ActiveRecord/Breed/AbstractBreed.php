<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Breed;

use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecord\PetType\AbstractPetType;
use VetmanagerApiGateway\ActiveRecord\PetType\PetTypeOnly;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\Breed\BreedOnlyDto;
use VetmanagerApiGateway\DTO\Breed\BreedOnlyDtoInterface;

/**
 * @property-read BreedOnlyDto $originalDto
 * @property positive-int $id
 * @property non-empty-string $title
 * @property positive-int $typeId
 * @property array{
 *     id: string,
 *     title: string,
 *     pet_type_id: string,
 *     petType: array{
 *          id: string,
 *          title: string,
 *          picture: string,
 *          type?: string
 *      }
 * } $originalDataArray 'petType' массив только при GetById
 * @property-read PetTypeOnly $type
 */
abstract class AbstractBreed extends AbstractActiveRecord implements BreedOnlyDtoInterface
{
    public static function getRouteKey(): string
    {
        return 'breed';
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, BreedOnlyDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    public function getId(): int
    {
        return $this->modelDTO->getId();
    }

    public function getTitle(): string
    {
        return $this->modelDTO->getTitle();
    }

    public function getPetTypeId(): int
    {
        return $this->modelDTO->getPetTypeId();
    }

    public function setId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setId($value));
    }

    public function setTitle(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setTitle($value));
    }

    public function setPetTypeId(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setPetTypeId($value));
    }

    abstract public function getPetType(): AbstractPetType;

}
