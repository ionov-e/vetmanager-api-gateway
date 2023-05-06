<?php

namespace VetmanagerApiGateway\ActiveRecord\Trait;

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
     * @return self[]
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public static function getByQueryBuilder(ApiGateway $apiGateway, Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        $response = $apiGateway->getWithQueryBuilder(self::getApiModel(), $builder, $maxLimitOfReturnedModels, $pageNumber);
        return self::fromResponse($apiGateway, $response);
    }

    /** @inheritDoc
     * @return self[]
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public static function getByPagedQuery(ApiGateway $apiGateway, PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        $response = $apiGateway->getWithPagedQuery(self::getApiModel(), $pagedQuery, $maxLimitOfReturnedModels);
        return self::fromResponse($apiGateway, $response);
    }

    /** @inheritDoc
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public static function getByParametersAsString(ApiGateway $apiGateway, string $getParameters): array
    {
        return self::fromResponse(
            $apiGateway,
            $apiGateway->getWithGetParametersAsString(self::getApiModel(), $getParameters)
        );
    }
}
