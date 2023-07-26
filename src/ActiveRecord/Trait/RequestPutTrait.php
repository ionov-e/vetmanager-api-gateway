<?php

namespace VetmanagerApiGateway\ActiveRecord\Trait;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

trait RequestPutTrait
{

    /** @inheritDoc
     * @throws VetmanagerApiGatewayException
     */
    public function edit(): static
    {
        return static::editUsingIdAndArray(
            $this->activeRecordFactory,
            $this->userMadeDto->getIdForPutRequest(),
            $this->userMadeDto->getAsArrayForPutRequest()
        );
    }

    /** @inheritDoc
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public static function editUsingIdAndArray(ApiGateway $apiGateway, int $id, array $data): static
    {
        return new static(
            $apiGateway,
            $apiGateway->put(static::getApiModel(), $id, $data)
        );
    }
}
