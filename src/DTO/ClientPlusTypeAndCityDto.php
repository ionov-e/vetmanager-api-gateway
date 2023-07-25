<?php

namespace VetmanagerApiGateway\DTO;

class ClientPlusTypeAndCityDto extends ClientDto
{
    public function __construct(
        protected ?string       $id,
        protected ?string       $address,
        protected ?string       $home_phone,
        protected ?string       $work_phone,
        protected ?string       $note,
        protected ?string       $type_id,
        protected ?string       $how_find,
        protected ?string       $balance,
        protected ?string       $email,
        protected ?string       $city,
        protected ?string       $city_id,
        protected ?string       $date_register,
        protected ?string       $cell_phone,
        protected ?string       $zip,
        protected ?string       $registration_index,
        protected ?string       $vip,
        protected ?string       $last_name,
        protected ?string       $first_name,
        protected ?string       $middle_name,
        protected ?string       $status,
        protected ?string       $discount,
        protected ?string       $passport_series,
        protected ?string       $lab_number,
        protected ?string       $street_id,
        protected ?string       $apartment,
        protected ?string       $unsubscribe,
        protected ?string       $in_blacklist,
        protected ?string       $last_visit_date,
        protected ?string       $number_of_journal,
        protected ?string       $phone_prefix,
        protected ?CityDto       $city_data,
        protected ?ClientTypeDto $client_type_data
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

    public function getCity(): ?CityDto
    {
        return ($this->city_data) ?: null;
    }

    public function getClientType(): ?ClientTypeDto
    {
        return $this->client_type_data ?: null;
    }
}