<?php

namespace VetmanagerApiGateway\ActiveRecord\Interface;

use VetmanagerApiGateway\ApiGateway;

interface RequestGetByIdInterface
{
    /** Получение модели (используя ID модели) по АПИ Get-запросу */
    public static function getById(ApiGateway $apiGateway, int $id): static;

    /** Создать объект, используя массив полученный Get-запросом по ID (т.е. создание объекта из кэша скорее всего) */
    public static function fromSingleDtoArrayAsFromGetById(ApiGateway $apiGateway, array $originalDataArray): static;
}
