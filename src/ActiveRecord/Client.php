<?php

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\ClientDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

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
        return $this->getCityId() ? City::getById($this->activeRecordFactory, $this->getCityId()) : null;
    }

    /** @throws VetmanagerApiGatewayException */
    function getClientTypeTitle(): string
    {
        return ClientPlusTypeAndCity::getById($this->activeRecordFactory, $this->getId())->getClientTypeTitle();
    }
}