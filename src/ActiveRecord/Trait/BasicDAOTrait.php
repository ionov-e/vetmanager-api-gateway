<?php

namespace VetmanagerApiGateway\ActiveRecord\Trait;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

trait BasicDAOTrait
{
    /** @inheritDoc
     * @return static[]
     * @throws VetmanagerApiGatewayResponseException
     */
    public static function fromResponse(ApiGateway $apiGateway, array $apiResponse): array
    {
        $modelKey = self::getApiModel()->getApiModelResponseKey();

        if (!isset($apiResponse[$modelKey])) {
            /** @psalm-suppress PossiblyInvalidCast Бредовое предупреждение */
            throw new VetmanagerApiGatewayResponseException("Ключ модели не найден в ответе АПИ: '$modelKey'");
        }

        return self::fromMultipleObjectsContents(
            $apiGateway,
            $apiResponse[$modelKey]
        );
    }
}
