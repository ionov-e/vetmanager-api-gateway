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
     * @return static[]
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public static function getAll(ApiGateway $apiGateway, int $maxLimitOfReturnedModels = 100): array
    {
        return static::getByPagedQuery($apiGateway, (new Builder())->top($maxLimitOfReturnedModels), $maxLimitOfReturnedModels);
    }

    /** @throws VetmanagerApiGatewayException */
    public static function fromSingleDtoArrayAsFromGetAllOrByQuery(ApiGateway $apiGateway, array $originalDataArray): static
    {
        return static::fromSingleDtoArray($apiGateway, $originalDataArray, static::getCompletenessFromGetAllOrByQuery());
    }
}
