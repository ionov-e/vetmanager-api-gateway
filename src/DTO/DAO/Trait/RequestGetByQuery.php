<?php

namespace VetmanagerApiGateway\DTO\DAO\Trait;

use Otis22\VetmanagerRestApi\Query\Builder;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

trait RequestGetByQuery
{
    /** @inheritDoc
     * @return static[]
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public static function getByQueryBuilder(ApiGateway $apiGateway, Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        $response = $apiGateway->getWithQueryBuilder(static::getApiModel(), $builder, $maxLimitOfReturnedModels, $pageNumber);
        return static::fromResponse($apiGateway, $response);
    }

    /** @inheritDoc
     * @return static[]
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public static function getByPagedQuery(ApiGateway $apiGateway, PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        $response = $apiGateway->getWithPagedQuery(static::getApiModel(), $pagedQuery, $maxLimitOfReturnedModels);
        return static::fromResponse($apiGateway, $response);
    }

    /** @inheritDoc
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public static function getByParametersAsString(ApiGateway $apiGateway, string $getParameters): array
    {
        return self::fromResponse(
            $apiGateway,
            $apiGateway->getWithGetParametersAsString(static::getApiModel(), $getParameters)
        );
    }
}
