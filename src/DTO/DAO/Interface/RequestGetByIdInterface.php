<?php

namespace VetmanagerApiGateway\DTO\DAO\Interface;

use VetmanagerApiGateway\ApiGateway;

interface RequestGetByIdInterface extends BasicDAOInterface
{
    /** Получение модели (используя ID модели) по АПИ Get-запросу */
    public static function fromRequestGetById(ApiGateway $apiGateway, int $id): static;
}
