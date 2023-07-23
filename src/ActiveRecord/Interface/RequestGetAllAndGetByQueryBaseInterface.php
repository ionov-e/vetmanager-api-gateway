<?php

namespace VetmanagerApiGateway\ActiveRecord\Interface;

use VetmanagerApiGateway\ApiGateway;

interface RequestGetAllAndGetByQueryBaseInterface
{
    /** Создать объект, используя массив полученный запросом Get All с или без использования Query.
     * Т.е. создание объекта из полученного ранее массива, например из кэша. */
    public static function fromSingleDtoArrayAsFromGetAllOrByQuery(ApiGateway $apiGateway, array $originalDataArray): static;
}
