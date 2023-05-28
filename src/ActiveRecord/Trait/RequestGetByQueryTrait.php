<?php

namespace VetmanagerApiGateway\ActiveRecord\Trait;

use Otis22\VetmanagerRestApi\Query\Builder;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

trait RequestGetByQueryTrait
{
    /** @inheritDoc
     * @return static[]
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public static function getByQueryBuilder(ApiGateway $apiGateway, Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        $response = $apiGateway->getWithQueryBuilder(static::getApiModel(), $builder, $maxLimitOfReturnedModels, $pageNumber);
        return static::fromApiResponseArray($apiGateway, $response, static::getCompletenessFromGetAllOrByQuery());
    }

    /** @inheritDoc
     * @return static[]
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public static function getByPagedQuery(ApiGateway $apiGateway, PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        $response = $apiGateway->getWithPagedQuery(static::getApiModel(), $pagedQuery, $maxLimitOfReturnedModels);
        return static::fromApiResponseArray($apiGateway, $response, static::getCompletenessFromGetAllOrByQuery());
    }

    /** @inheritDoc
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public static function getByParametersAsString(ApiGateway $apiGateway, string $getParameters): array
    {
        return static::fromApiResponseArray(
            $apiGateway,
            $apiGateway->getWithGetParametersAsString(static::getApiModel(), $getParameters),
            static::getCompletenessFromGetAllOrByQuery()
        );
    }

    /** @throws VetmanagerApiGatewayException */
    public static function fromSingleDtoArrayAsFromGetByQuery(ApiGateway $apiGateway, array $originalDataArray): static
    {
        return static::fromSingleDtoArray($apiGateway, $originalDataArray, static::getCompletenessFromGetAllOrByQuery());
    }
}
