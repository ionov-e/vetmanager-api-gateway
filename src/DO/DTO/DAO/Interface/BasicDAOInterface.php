<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO\DTO\DAO\Interface;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\Enum\ApiRoute;

/** Обязательный интерфейс для всех классов DAO (дочерних классов от DTO, поддерживающих прямые АПИ-запросы на сервера Ветменеджер) */
interface BasicDAOInterface
{
    /** Используется при АПИ-запросах (роуты и имена моделей из тела JSON-ответа на АПИ запрос) */
    public static function getApiModel(): ApiRoute;

    /**
     * @return static[]
     */
    public static function fromResponse(ApiGateway $apiGateway, array $apiResponse): array;
}
