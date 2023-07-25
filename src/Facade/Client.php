<?php

namespace VetmanagerApiGateway\Facade;

use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\DTO\ClientPlusTypeAndCityDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class Client extends AbstractFacade
{
    private static function getApiModel()
    {
        return ActiveRecord\ClientPlusTypeAndCity::getApiModel();
    }

    public static function getDefaultActiveRecord(): string
    {
        return ActiveRecord\Client::class;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ActiveRecord\ClientPlusTypeAndCity
    {
        return self::protectedGetById($this->apiGateway,
            self::getApiModel(),
            ActiveRecord\ClientPlusTypeAndCity::class,
            ClientPlusTypeAndCityDto::class,
            $id);
//        $apiResponseAsArray = $this->apiGateway->getWithId(self::getApiModel(), $id);
//        /** @var ClientPlusTypeAndCityDto $dto */
//        $dto = $this->apiGateway->getDtoFactory()->getAsDtoFromApiResponse($apiResponseAsArray,
//            self::getApiModel()->getResponseKey(),
//            ClientPlusTypeAndCityDto::class
//        );
//        return new ActiveRecord\ClientPlusTypeAndCity($this->apiGateway, $dto);
    }

    public function getAll(): ActiveRecord\ClientPlusTypeAndCity
    {
        return static::fromSingleDtoArrayAsFromGetById(
            $this->apiGateway,
            $this->apiGateway->getWithQueryBuilder()
        );
    }
}