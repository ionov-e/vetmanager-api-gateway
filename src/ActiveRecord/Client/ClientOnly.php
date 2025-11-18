<?php

namespace VetmanagerApiGateway\ActiveRecord\Client;

use VetmanagerApiGateway\ActiveRecord\City\City;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\Client\ClientOnlyDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade;

class ClientOnly extends AbstractClient
{
    public function __construct(ActiveRecordFactory $activeRecordFactory, ClientOnlyDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    public static function getDtoClass(): string
    {
        return ClientOnlyDto::class;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getCity(): ?City
    {
        return $this->getCityId() ? (new Facade\City($this->activeRecordFactory))->getById($this->getCityId()) : null;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getClientTypeTitle(): string
    {
        return (new Facade\Client($this->activeRecordFactory))->getById($this->getId())->getClientTypeTitle();
    }
}
