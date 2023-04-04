<?php

namespace VetmanagerApiGateway\DTO\DAO\Interface;

use VetmanagerApiGateway\ApiGateway;

interface RequestGetAllInterface extends BasicDAOInterface
{
    /** Получение всех существующих моделей по АПИ Get-запросу */
    public static function getAll(ApiGateway $apiGateway, int $maxLimitOfReturnedModels): array;
}
