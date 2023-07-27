<?php

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\ClientDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade;

class Client extends AbstractClient
{
    public function __construct(ActiveRecordFactory $activeRecordFactory, ClientDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    public static function getDtoClass(): string
    {
        return ClientDto::class;
    }

    /** @throws VetmanagerApiGatewayException */
    function getCity(): ?City
    {
        return $this->getCityId() ? (new Facade\City($this->activeRecordFactory))->getById($this->getCityId()) : null;
    }

    /** @throws VetmanagerApiGatewayException */
    function getClientTypeTitle(): string
    {
        return (new Facade\Client($this->activeRecordFactory))->getById($this->getId())->getClientTypeTitle();
    }
}