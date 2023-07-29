<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\CityType;

use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\CityType\CityTypeDtoInterface;
use VetmanagerApiGateway\DTO\CityType\CityTypeOnlyDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

/**
 * @property-read CityTypeOnlyDto $originalDto
 * @property positive-int $id
 * @property string $title
 * @property-read array{
 *     id: string,
 *     title: string
 * } $originalDataArray
 */
final class CityType extends AbstractActiveRecord implements CityTypeDtoInterface
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

    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int
    {
        return $this->modelDTO->getId();
    }

    public function setId(int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setId($value));
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
