<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Interface\AllRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllRequestsTrait;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO\CityTypeDto;
use VetmanagerApiGateway\DTO\CityTypeDtoInterface;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

/**
 * @property-read CityTypeDto $originalDto
 * @property positive-int $id
 * @property string $title
 * @property-read array{
 *     id: string,
 *     title: string
 * } $originalDataArray
 */
final class CityType extends AbstractActiveRecord implements CityTypeDtoInterface, AllRequestsInterface
{
    use AllRequestsTrait;

    public function __construct(ApiGateway $apiGateway, CityTypeDto $modelDTO)
    {
        parent::__construct($apiGateway, $modelDTO);
        $this->apiGateway = $apiGateway;
        $this->modelDTO = $modelDTO;
    }

    /** @return ApiModel::CityType */
    public static function getApiModel(): ApiModel
    {
        return ApiModel::CityType;
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

    //    public static function getCompletenessFromGetAllOrByQuery(): Completeness { return Completeness::Full; }
}
