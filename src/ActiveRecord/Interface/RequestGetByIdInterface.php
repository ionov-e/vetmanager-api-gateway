<?php

namespace VetmanagerApiGateway\ActiveRecord\Interface;

use VetmanagerApiGateway\ApiGateway;

interface RequestGetByIdInterface extends BasicDAOInterface
{
    /** Получение модели (используя ID модели) по АПИ Get-запросу */
    public static function getById(ApiGateway $apiGateway, int $id): self;
}
