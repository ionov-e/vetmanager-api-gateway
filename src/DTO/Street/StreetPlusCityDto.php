<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Street;

use VetmanagerApiGateway\DTO\City\CityOnlyDto;

class StreetPlusCityDto extends StreetOnlyDto
{
    public function __construct(
        protected ?string     $id,
        protected ?string     $title,
        protected ?string     $city_id,
        protected ?string     $type,
        protected CityOnlyDto $city
    )
    {
        parent::__construct(
            $id,
            $title,
            $city_id,
            $type
        );
    }

    public function getCityOnlyDto(): CityOnlyDto
    {
        return $this->city;
    }
}
