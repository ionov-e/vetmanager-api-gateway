<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Street;

use VetmanagerApiGateway\ActiveRecord\City\City;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\Street\StreetPlusCityDto;

final class StreetPlusCity extends AbstractStreet
{
    public static function getDtoClass(): string
    {
        return StreetPlusCityDto::class;
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, StreetPlusCityDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    public function getCity(): City
    {
        return $this->activeRecordFactory->getFromSingleDto($this->modelDTO->getCityOnlyDto(), City::class);
    }
}
