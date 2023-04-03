<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\DAO\Interface;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO\Enum\ApiRoute;

/** Обязательный интерфейс для всех классов DAO (дочерних классов от DTO, поддерживающих прямые АПИ-запросы на сервера Ветменеджер) */
interface BasicDAOInterface
{
    /** Используется при АПИ-запросах (роуты и имена моделей из тела JSON-ответа на АПИ запрос) */
    public static function getApiModel(): ApiRoute;

    /** @param array{"totalCount": int, MODEL_NAME: array<int, array>} $apiResponse Раскодированный JSON ответа по АПИ. Ключом второго элемента будет название модели, а в самом элементе массивы (их может быть несколько, один или нисколько) с полученными моделями
     * @return static[]
     */
    public static function fromResponse(ApiGateway $apiGateway, array $apiResponse): array;
}
