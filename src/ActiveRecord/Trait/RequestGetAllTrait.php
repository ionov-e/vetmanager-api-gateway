<?php

namespace VetmanagerApiGateway\ActiveRecord\Trait;

use Otis22\VetmanagerRestApi\Query\Builder;
use VetmanagerApiGateway\ActiveRecord\Enum\Source;
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
    public static function fromSingleDtoArrayUsingGetAll(ApiGateway $apiGateway, array $originalData): self
    {
        return self::fromSingleDtoArray($apiGateway, $originalData, Source::GetByAllList);
    }
}
