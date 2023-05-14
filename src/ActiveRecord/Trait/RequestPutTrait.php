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
    public function edit(): self
    {
        return self::editUsingIdAndArray(
            $this->apiGateway,
            $this->userMadeDto->getIdForPutRequest(),
            $this->userMadeDto->getAsArrayForPutRequest()
        );
    }

    /** @inheritDoc
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public static function editUsingIdAndArray(ApiGateway $apiGateway, int $id, array $data): self
    {
        return new self(
            $apiGateway,
            $apiGateway->put(self::getApiModel(), $id, $data)
        );
    }
}
