<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\PetType;

use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecord\Breed\AbstractBreed;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\PetType\PetTypeOnlyDto;
use VetmanagerApiGateway\DTO\PetType\PetTypeOnlyDtoInterface;

///**
// * @property-read PetTypeOnlyDto $originalDto
// * @property positive-int id
// * @property string title
// * @property string picture
// * @property string type
// * @property-read array{
// *     id: string,
// *     title: string,
// *     picture: string,
// *     type: ?string,
// *     breeds: list<array{
// *              id: string,
// *              title: string,
// *              pet_type_id: string
// *          }>
// * } $originalDataArray 'breeds' массив только при GetById
// */
abstract class AbstractPetType extends AbstractActiveRecord implements PetTypeOnlyDtoInterface
{
    public static function getRouteKey(): string
    {
        return 'petType';
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, PetTypeOnlyDto $modelDTO)
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

    public function getPicture(): string
    {
        return $this->modelDTO->getPicture();
    }

    public function getType(): string
    {
        return $this->modelDTO->getType();
    }

    public function setId(int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setId($value));
    }

    public function setTitle(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setTitle($value));
    }

    public function setPicture(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setPicture($value));
    }

    public function setType(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setType($value));
    }

    /** @return AbstractBreed[] */
    abstract public function getBreeds(): array;
}
