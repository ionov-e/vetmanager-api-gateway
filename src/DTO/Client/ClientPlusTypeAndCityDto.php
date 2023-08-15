<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Client;

use VetmanagerApiGateway\DTO\City\CityOnlyDto;
use VetmanagerApiGateway\DTO\ClientType\ClientTypeOnlyDto;

class ClientPlusTypeAndCityDto extends ClientOnlyDto
{
    /**
     * @param string|null $id
     * @param string|null $address
     * @param string|null $home_phone
     * @param string|null $work_phone
     * @param string|null $note
     * @param string|null $type_id
     * @param string|null $how_find
     * @param string|null $balance
     * @param string|null $email
     * @param string|null $city
     * @param string|null $city_id
     * @param string|null $date_register
     * @param string|null $cell_phone
     * @param string|null $zip
     * @param string|null $registration_index
     * @param string|null $vip
     * @param string|null $last_name
     * @param string|null $first_name
     * @param string|null $middle_name
     * @param string|null $status
     * @param string|null $discount
     * @param string|null $passport_series
     * @param string|null $lab_number
     * @param string|null $street_id
     * @param string|null $apartment
     * @param string|null $unsubscribe
     * @param string|null $in_blacklist
     * @param string|null $last_visit_date
     * @param string|null $number_of_journal
     * @param string|null $phone_prefix
     * @param CityOnlyDto|null $city_data
     * @param ClientTypeOnlyDto|null $client_type_data
     */
    public function __construct(
        protected ?string            $id,
        protected ?string            $address,
        protected ?string            $home_phone,
        protected ?string            $work_phone,
        protected ?string            $note,
        protected ?string            $type_id,
        protected ?string            $how_find,
        protected ?string            $balance,
        protected ?string            $email,
        protected ?string            $city,
        protected ?string            $city_id,
        protected ?string            $date_register,
        protected ?string            $cell_phone,
        protected ?string            $zip,
        protected ?string            $registration_index,
        protected ?string            $vip,
        protected ?string            $last_name,
        protected ?string            $first_name,
        protected ?string            $middle_name,
        protected ?string            $status,
        protected ?string            $discount,
        protected ?string            $passport_series,
        protected ?string            $lab_number,
        protected ?string            $street_id,
        protected ?string            $apartment,
        protected ?string            $unsubscribe,
        protected ?string            $in_blacklist,
        protected ?string            $last_visit_date,
        protected ?string            $number_of_journal,
        protected ?string            $phone_prefix,
        protected ?CityOnlyDto       $city_data,
        protected ?ClientTypeOnlyDto $client_type_data
    )
    {
        parent::__construct(
            $id,
            $address,
            $home_phone,
            $work_phone,
            $note,
            $type_id,
            $how_find,
            $balance,
            $email,
            $city,
            $city_id,
            $date_register,
            $cell_phone,
            $zip,
            $registration_index,
            $vip,
            $last_name,
            $first_name,
            $middle_name,
            $status,
            $discount,
            $passport_series,
            $lab_number,
            $street_id,
            $apartment,
            $unsubscribe,
            $in_blacklist,
            $last_visit_date,
            $number_of_journal,
            $phone_prefix
        );
    }

    public function getCityDto(): ?CityOnlyDto
    {
        return ($this->city_data) ?: null;
    }

    public function getClientTypeDto(): ?ClientTypeOnlyDto
    {
        return $this->client_type_data ?: null;
    }
}