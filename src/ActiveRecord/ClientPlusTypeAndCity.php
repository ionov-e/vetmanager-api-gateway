<?php

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\ClientPlusTypeAndCityDto;

class ClientPlusTypeAndCity extends AbstractClient
{
    public function __construct(ActiveRecordFactory $activeRecordFactory, ClientPlusTypeAndCityDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->activeRecordFactory = $activeRecordFactory;
        $this->modelDTO = $modelDTO;
    }

    public static function getDtoClass(): string
    {
        return ClientPlusTypeAndCityDto::class;
    }

    function getCity(): ?City
    {
        return $this->modelDTO->getCity() ? new City($this->activeRecordFactory, $this->modelDTO->getCity()) : null;
    }

    function getClientTypeTitle(): string
    {
        $clientType = $this->modelDTO->getClientType();
        return $clientType ? $clientType->getTitle() : "";
    }
}