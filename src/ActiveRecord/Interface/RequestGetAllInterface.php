<?php

namespace VetmanagerApiGateway\ActiveRecord\Interface;

use VetmanagerApiGateway\ApiGateway;

interface RequestGetAllInterface
{
    /** Получение всех существующих моделей по АПИ Get-запросу */
    public static function getAll(ApiGateway $apiGateway, int $maxLimitOfReturnedModels): array;

    /** Создать объект, используя массив полученный запросом Get All (т.е. создание объекта из кэша скорее всего) */
    public static function fromSingleDtoArrayUsingGetAll(ApiGateway $apiGateway, array $originalData): self;
}
