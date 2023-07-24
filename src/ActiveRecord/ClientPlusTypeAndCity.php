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

    function getCity(): City
    {
        return new City($this->apiGateway, $this->modelDTO->getCity());
    }

    function getClientTypeTitle(): string
    {
        return $this->modelDTO->getCityTitle();
    }
}