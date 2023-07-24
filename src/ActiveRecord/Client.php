<?php

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO\ClientDto;

class Client extends AbstractClient
{
    public function __construct(ApiGateway $apiGateway, ClientDto $modelDTO)
    {
        parent::__construct($apiGateway, $modelDTO);
        $this->apiGateway = $apiGateway;
        $this->modelDTO = $modelDTO;
    }

    function getCity(): City
    {
        // TODO: Implement getCity() method.
    }

    function getClientTypeTitle(): string
    {
        // TODO: Implement getClientTypeTitle() method.
    }
}