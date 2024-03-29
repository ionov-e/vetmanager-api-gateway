<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Street;

use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecord\City\City;
use VetmanagerApiGateway\ActiveRecord\CreatableInterface;
use VetmanagerApiGateway\ActiveRecord\DeletableInterface;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\Street\StreetOnlyDto;
use VetmanagerApiGateway\DTO\Street\StreetOnlyDtoInterface;
use VetmanagerApiGateway\DTO\Street\TypeEnum;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade;

///**
// * @property-read StreetOnlyDto $originalDto
// * @property positive-int $id
// * @property string $title Default: ''
// * @property TypeEnum $type Default: 'street'
// * @property positive-int $cityId
// * @property-read array{
// *     id: string,
// *     title: string,
// *     city_id: string,
// *     type: string,
// *     city?: array{
// *              id: string,
// *              title: ?string,
// *              type_id: ?string
// *     }
// * } $originalDataArray
// * @property-read ?City $city
// */
abstract class AbstractStreet extends AbstractActiveRecord implements StreetOnlyDtoInterface, CreatableInterface, DeletableInterface
{
    public static function getRouteKey(): string
    {
        return 'street';
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, StreetOnlyDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    /** @throws VetmanagerApiGatewayException */
    public function create(): self
    {
        return (new Facade\Street($this->activeRecordFactory))->createNewUsingArray($this->getAsArrayWithSetPropertiesOnly());
    }

    /** @throws VetmanagerApiGatewayException */
    public function update(): self
    {
        return (new Facade\Street($this->activeRecordFactory))->updateUsingIdAndArray($this->getId(), $this->getAsArrayWithSetPropertiesOnly());
    }

    /** @throws VetmanagerApiGatewayException */
    public function delete(): void
    {
        (new Facade\Street($this->activeRecordFactory))->delete($this->getId());
    }

    /** @inheritDoc */
    public function getId(): int
    {
        return $this->modelDTO->getId();
    }

    /** @inheritDoc */
    public function getTitle(): ?string
    {
        return $this->modelDTO->getTitle();
    }

    /** @inheritDoc */
    public function getCityId(): int
    {
        return $this->modelDTO->getCityId();
    }

    /** @inheritDoc */
    public function getTypeAsString(): ?string
    {
        return $this->modelDTO->getTypeAsString();
    }

    /** @inheritDoc */
    public function getTypeAsEnum(): TypeEnum
    {
        return $this->modelDTO->getTypeAsEnum();
    }

    /** @inheritDoc */
    public function setTitle(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setTitle($value));
    }

    /** @inheritDoc */
    public function setCityId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setCityId($value));
    }

    /** @inheritDoc */
    public function setTypeFromString(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setTypeFromString($value));
    }

    /** @inheritDoc */
    public function setTypeFromEnum(TypeEnum $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setTypeFromEnum($value));
    }

    abstract public function getCity(): City;
}
