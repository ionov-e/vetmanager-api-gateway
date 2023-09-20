<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Street;

use VetmanagerApiGateway\DTO\City\CityOnlyDto;

class StreetPlusCityDto extends StreetOnlyDto
{
    /**
     * @param int|null $id
     * @param string|null $title
     * @param int|null $city_id
     * @param string|null $type
     * @param CityOnlyDto $city
     */
    public function __construct(
        protected ?int        $id,
        protected ?string     $title,
        protected ?int        $city_id,
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
