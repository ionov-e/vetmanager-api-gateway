<?php

namespace VetmanagerApiGateway\ActiveRecord\Client;

use VetmanagerApiGateway\ActiveRecord\City\City;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\Client\ClientPlusTypeAndCityDto;

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

    public function getCity(): ?City
    {
        return $this->modelDTO->getCityDto() ? new City($this->activeRecordFactory, $this->modelDTO->getCityDto()) : null;
    }

    public function getClientTypeTitle(): string
    {
        $clientType = $this->modelDTO->getClientTypeDto();
        return $clientType ? $clientType->getTitle() : "";
    }
}
