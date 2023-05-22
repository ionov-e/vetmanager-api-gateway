<?php

namespace VetmanagerApiGateway\ActiveRecord\Trait;

use Otis22\VetmanagerRestApi\Query\Builder;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

trait RequestGetAllTrait
{
    /** @inheritDoc
     * @return self[]
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public static function getAll(ApiGateway $apiGateway, int $maxLimitOfReturnedModels = 100): array
    {
        return self::getByPagedQuery($apiGateway, (new Builder())->top($maxLimitOfReturnedModels), $maxLimitOfReturnedModels);
    }

    /** @throws VetmanagerApiGatewayException */
    public static function fromSingleDtoArrayAsFromGetAllOrByQuery(ApiGateway $apiGateway, array $originalDataArray): self
    {
        return self::fromSingleDtoArray($apiGateway, $originalDataArray, static::getCompletenessFromGetAllOrByQuery());
    }
}
