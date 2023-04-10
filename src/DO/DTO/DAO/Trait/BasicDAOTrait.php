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
        return self::fromMultipleObjectsContents(
            $apiGateway,
            $apiResponse[self::getApiModel()->getApiModelResponseKey()]
        );
    }
}
