<?php

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO\ClientPlusTypeAndCityDto;

class ClientPlusTypeAndCity extends AbstractClient
{
    public function __construct(ApiGateway $apiGateway, ClientPlusTypeAndCityDto $modelDTO)
    {
        parent::__construct($apiGateway, $modelDTO);
        $this->apiGateway = $apiGateway;
        $this->modelDTO = $modelDTO;
    }

    public static function getDtoClass(): string
    {
        return ClientPlusTypeAndCityDto::class;
    }

    function getCity(): ?City
    {
        return $this->modelDTO->getCity() ? new City($this->apiGateway, $this->modelDTO->getCity()) : null;
    }

    function getClientTypeTitle(): string
    {
        $clientType = $this->modelDTO->getClientType();
        return $clientType ? $clientType->getTitle() : "";
    }
}