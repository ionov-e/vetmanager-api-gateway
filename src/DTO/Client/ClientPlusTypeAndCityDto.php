<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Client;

use VetmanagerApiGateway\DTO\City\CityOnlyDto;
use VetmanagerApiGateway\DTO\ClientType\ClientTypeOnlyDto;

class ClientPlusTypeAndCityDto extends ClientOnlyDto
{
    /**
     * @param int|string|null $id
     * @param string|null $address
     * @param string|null $home_phone
     * @param string|null $work_phone
     * @param string|null $note
     * @param int|string|null $type_id
     * @param int|string|null $how_find
     * @param string|null $balance
     * @param string|null $email
     * @param string|null $city
     * @param int|string|null $city_id
     * @param string|null $date_register
     * @param string|null $cell_phone
     * @param string|null $zip
     * @param string|null $registration_index
     * @param int|string|null $vip
     * @param string|null $last_name
     * @param string|null $first_name
     * @param string|null $middle_name
     * @param string|null $status
     * @param int|string|null $discount
     * @param string|null $passport_series
     * @param string|null $lab_number
     * @param int|string|null $street_id
     * @param string|null $apartment
     * @param int|string|null $unsubscribe
     * @param int|string|null $in_blacklist
     * @param string|null $last_visit_date
     * @param string|null $number_of_journal
     * @param string|null $phone_prefix
     * @param CityOnlyDto|null $city_data
     * @param ClientTypeOnlyDto|null $client_type_data
     */
    public function __construct(
        protected int|string|null $id,
        protected ?string         $address,
        protected ?string         $home_phone,
        protected ?string         $work_phone,
        protected ?string         $note,
        protected int|string|null $type_id,
        protected int|string|null $how_find,
        protected ?string         $balance,
        protected ?string         $email,
        protected ?string         $city,
        protected int|string|null $city_id,
        protected ?string         $date_register,
        protected ?string         $cell_phone,
        protected ?string            $zip,
        protected ?string            $registration_index,
        protected int|string|null $vip,
        protected ?string            $last_name,
        protected ?string            $first_name,
        protected ?string            $middle_name,
        protected ?string            $status,
        protected int|string|null $discount,
        protected ?string            $passport_series,
        protected ?string            $lab_number,
        protected int|string|null $street_id,
        protected ?string            $apartment,
        protected int|string|null $unsubscribe,
        protected int|string|null $in_blacklist,
        protected ?string            $last_visit_date,
        protected ?string            $number_of_journal,
        protected ?string            $phone_prefix,
        protected ?CityOnlyDto       $city_data,
        protected ?ClientTypeOnlyDto $client_type_data
    ) {
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
