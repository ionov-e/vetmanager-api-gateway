<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\City;

use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecord\CityType\CityType;
use VetmanagerApiGateway\ActiveRecord\CreatableInterface;
use VetmanagerApiGateway\ActiveRecord\DeletableInterface;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\City\CityDtoInterface;
use VetmanagerApiGateway\DTO\City\CityOnlyDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;
use VetmanagerApiGateway\Facade;

///**
// * @property CityOnlyDto $originalDto
// * @property positive-int $id
// * @property string $title
// * @property positive-int $typeId Default: 1
// * @property-read CityType $type
// * @property-read array{
// *     id: string,
// *     title: string,
// *     type_id: string
// * } $originalDataArray
// */
final class City extends AbstractActiveRecord implements CityDtoInterface, CreatableInterface, DeletableInterface
{
    public function __construct(ActiveRecordFactory $activeRecordFactory, CityOnlyDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    public static function getDtoClass(): string
    {
        return CityOnlyDto::class;
    }

    public static function getRouteKey(): string
    {
        return 'city';
    }

    /** @throws VetmanagerApiGatewayException */
    public function create(): self
    {
        return (new Facade\City($this->activeRecordFactory))->createNewUsingArray($this->getAsArrayWithSetPropertiesOnly());
    }

    /** @throws VetmanagerApiGatewayException */
    public function update(): self
    {
        return (new Facade\City($this->activeRecordFactory))->updateUsingIdAndArray($this->getId(), $this->getAsArrayWithSetPropertiesOnly());
    }

    /** @throws VetmanagerApiGatewayException */
    public function delete(): void
    {
        (new Facade\City($this->activeRecordFactory))->delete($this->getId());
    }

    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int
    {
        return $this->modelDTO->getId();
    }

    public function getTitle(): string
    {
        return $this->modelDTO->getTitle();
    }

    public function setTitle(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setTitle($value));
    }

    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getTypeId(): int
    {
        return $this->modelDTO->getTypeId();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTypeId(int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setTypeId($value));
    }

    /** @throws VetmanagerApiGatewayException */
    public function getCityType(): CityType
    {
        return (new Facade\CityType($this->activeRecordFactory))->getById($this->modelDTO->getTypeId());
    }
}
