<?php

namespace VetmanagerApiGateway\ActiveRecord\Interface;

use VetmanagerApiGateway\ActiveRecord\Enum\Completeness;
use VetmanagerApiGateway\ApiGateway;

interface RequestGetAllAndGetByQueryBaseInterface
{
    /** Создать объект, используя массив полученный запросом Get All с или без использования Query.
     * Т.е. создание объекта из полученного ранее массива, например из кэша. */
    public static function fromSingleDtoArrayAsFromGetAllOrByQuery(ApiGateway $apiGateway, array $originalDataArray): static;

    /** На сколько полон ActiveRecord, полученный через запрос Get All или используя Query */
    public static function getCompletenessFromGetAllOrByQuery(): Completeness;
}
