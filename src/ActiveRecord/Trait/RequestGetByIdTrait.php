<?php

namespace VetmanagerApiGateway\ActiveRecord\Trait;

use VetmanagerApiGateway\ActiveRecord\Enum\Source;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

trait RequestGetByIdTrait
{
    /** @inheritDoc
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public static function getById(ApiGateway $apiGateway, int $id): self
    {
        return self::fromSingleArrayUsingGetById(
            $apiGateway,
            $apiGateway->getWithId(self::getApiModel(), $id)
        );
    }

    /** @throws VetmanagerApiGatewayException */
    public static function fromSingleArrayUsingGetById(ApiGateway $apiGateway, array $originalData): self
    {
        return self::fromSingleObjectContents($apiGateway, $originalData, Source::GetById);
    }
}
