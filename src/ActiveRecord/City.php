<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Interface\AllRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllRequestsTrait;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO\CityDto;
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
final class City extends AbstractActiveRecord implements AllRequestsInterface
{

    use AllRequestsTrait;

    public function __construct(ApiGateway $apiGateway, CityDto $modelDTO)
    {
        $this->apiGateway = $apiGateway;
        $this->modelDTO = $modelDTO;
    }

    /** @return ApiModel::City */
    public static function getApiModel(): ApiModel
    {
        return ApiModel::City;
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

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTitle(string $value): static
    {
        $this->modelDTO = $this->modelDTO->setTitle($value);
        return $this;
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
        $this->modelDTO = $this->modelDTO->setTypeId($value);
        return $this;
    }

//    public static function getCompletenessFromGetAllOrByQuery(): Completeness
//    {
//        return Completeness::Full;
//    }

    /** @throws VetmanagerApiGatewayException */
    public function getCityType(): CityType
    {
        return CityType::getById($this->apiGateway, $this->modelDTO->getTypeId());
    }
}
