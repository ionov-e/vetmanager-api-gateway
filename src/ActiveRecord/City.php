<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Interface\AllRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllRequestsTrait;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\CityDto;
use VetmanagerApiGateway\DTO\CityDtoInterface;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

/**
 * @property CityDto $originalDto
 * @property positive-int $id
 * @property string $title
 * @property positive-int $typeId Default: 1
 * @property-read CityType $type
 * @property-read array{
 *     id: string,
 *     title: string,
 *     type_id: string
 * } $originalDataArray
 */
final class City extends AbstractActiveRecord implements CityDtoInterface
{
    use AllRequestsTrait;

    public function __construct(ActiveRecordFactory $activeRecordFactory, CityDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    /** @return ApiModel::City */
    public static function getApiModel(): ApiModel
    {
        return ApiModel::City;
    }
    public static function getDtoClass(): string
    {
        return CityDto::class;
    }

    public static function getRouteKey(): string
    {
        return 'city';
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

//    public static function getCompletenessFromGetAllOrByQuery(): Completeness
//    {
//        return Completeness::Full;
//    }

    /** @throws VetmanagerApiGatewayException */
    public function getCityType(): CityType
    {
        return CityType::getById($this->activeRecordFactory, $this->modelDTO->getTypeId());
    }
}
