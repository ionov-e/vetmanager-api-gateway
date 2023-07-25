<?php

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO\ClientDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class Client extends AbstractClient
{
    public function __construct(ApiGateway $apiGateway, ClientDto $modelDTO)
    {
        parent::__construct($apiGateway, $modelDTO);
        $this->apiGateway = $apiGateway;
        $this->modelDTO = $modelDTO;
    }

    public static function getDtoClass(): string
    {
        return ClientDto::class;
    }

    /** @throws VetmanagerApiGatewayException */
    function getCity(): ?City
    {
        return $this->getCityId() ? City::getById($this->apiGateway, $this->getCityId()) : null;
    }

    /** @throws VetmanagerApiGatewayException */
    function getClientTypeTitle(): string
    {
        return ClientPlusTypeAndCity::getById($this->apiGateway, $this->getId())->getClientTypeTitle();
    }
}