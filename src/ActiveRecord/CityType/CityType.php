<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\CityType;

use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecord\CreatableInterface;
use VetmanagerApiGateway\ActiveRecord\DeletableInterface;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\CityType\CityTypeDtoInterface;
use VetmanagerApiGateway\DTO\CityType\CityTypeOnlyDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;
use VetmanagerApiGateway\Facade;

///**
// * @property-read CityTypeOnlyDto $originalDto
// * @property positive-int $id
// * @property string $title
// * @property-read array{
// *     id: string,
// *     title: string
// * } $originalDataArray
// */
final class CityType extends AbstractActiveRecord implements CityTypeDtoInterface, CreatableInterface, DeletableInterface
{
    public function __construct(ActiveRecordFactory $activeRecordFactory, CityTypeOnlyDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    public static function getDtoClass(): string
    {
        return CityTypeOnlyDto::class;
    }

    public static function getRouteKey(): string
    {
        return 'cityType';
    }

    /** @throws VetmanagerApiGatewayException */
    public function create(): self
    {
        return (new Facade\CityType($this->activeRecordFactory))->createNewUsingArray($this->getAsArrayWithSetPropertiesOnly());
    }

    /** @throws VetmanagerApiGatewayException */
    public function update(): self
    {
        return (new Facade\CityType($this->activeRecordFactory))->updateUsingIdAndArray($this->getId(), $this->getAsArrayWithSetPropertiesOnly());
    }

    /** @throws VetmanagerApiGatewayException */
    public function delete(): void
    {
        (new Facade\CityType($this->activeRecordFactory))->delete($this->getId());
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
}
