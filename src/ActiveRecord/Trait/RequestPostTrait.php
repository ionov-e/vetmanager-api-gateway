<?php

namespace VetmanagerApiGateway\ActiveRecord\Trait;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

trait RequestPostTrait
{
    /**
     * @inheritDoc
     * @throws VetmanagerApiGatewayException
     */
    public function createAsNew(): static
    {
        return static::createAsNewUsingArray(
            $this->activeRecordFactory,
            $this->activeRecordFactory->post(
                static::getApiModel(),
                $this->userMadeDto->getAsArrayForPostRequest()
            )
        );
    }

    /** @inheritDoc
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public static function createAsNewUsingArray(ApiGateway $apiGateway, array $data): static
    {
        return new static(
            $apiGateway,
            $apiGateway->post(static::getApiModel(), $data)
        );
    }
}
