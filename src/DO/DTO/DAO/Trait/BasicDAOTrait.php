<?php

namespace VetmanagerApiGateway\DO\DTO\DAO\Trait;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;

trait BasicDAOTrait
{
    /** @inheritDoc
     * @throws VetmanagerApiGatewayResponseEmptyException
     */
    public static function fromResponse(ApiGateway $apiGateway, array $apiResponse): array
    {
        return static::fromMultipleObjectsContents(
            $apiGateway,
            $apiResponse[static::getApiModel()->getApiModelResponseKey()]
        );
    }
}
