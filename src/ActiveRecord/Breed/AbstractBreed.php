<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Breed;

use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecord\CreatableInterface;
use VetmanagerApiGateway\ActiveRecord\DeletableInterface;
use VetmanagerApiGateway\ActiveRecord\PetType\AbstractPetType;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\Breed\BreedOnlyDto;
use VetmanagerApiGateway\DTO\Breed\BreedOnlyDtoInterface;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade;

///**
// * @property array{
// *     id: string,
// *     title: string,
// *     pet_type_id: string,
// *     petType: array{
// *          id: string,
// *          title: string,
// *          picture: string,
// *          type?: string
// *      }
// * } $originalDataArray 'petType' массив только при GetById
// */
abstract class AbstractBreed extends AbstractActiveRecord implements BreedOnlyDtoInterface, CreatableInterface, DeletableInterface
{
    public static function getRouteKey(): string
    {
        return 'breed';
    }

    /** @throws VetmanagerApiGatewayException */
    public function create(): BreedOnly
    {
        return (new Facade\Breed($this->activeRecordFactory))->createNewUsingArray($this->getAsArrayWithSetPropertiesOnly());
    }

    /** @throws VetmanagerApiGatewayException */
    public function update(): BreedOnly
    {
        return (new Facade\Breed($this->activeRecordFactory))->updateUsingIdAndArray($this->getId(), $this->getAsArrayWithSetPropertiesOnly());
    }

    /** @throws VetmanagerApiGatewayException */
    public function delete(): void
    {
        (new Facade\Breed($this->activeRecordFactory))->delete($this->getId());
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, BreedOnlyDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    /** @inheritDoc */
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

    public function setTitle(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setTitle($value));
    }

    public function setPetTypeId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setPetTypeId($value));
    }

    abstract public function getPetType(): AbstractPetType;
}
