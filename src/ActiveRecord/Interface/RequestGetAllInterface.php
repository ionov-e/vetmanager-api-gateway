<?php

namespace VetmanagerApiGateway\ActiveRecord\Interface;

use VetmanagerApiGateway\ApiGateway;

interface RequestGetAllInterface extends RequestGetAllAndGetByQueryBaseInterface
{
    /** Получение всех существующих моделей по АПИ Get-запросу */
    public static function getAll(ApiGateway $apiGateway, int $maxLimitOfReturnedModels): array;
}
