<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\DAO\Interface;

use Otis22\VetmanagerRestApi\Query\PagedQuery;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO\Enum\ApiRoute;

/** Интерфейс для классов DTO, поддерживающих прямые АПИ-запросы на сервера Ветменеджер */
interface AllConstructorsInterface
{
    /** Используется при АПИ-запросах (роуты и имена моделей из тела JSON-ответа на АПИ запрос) */
    public static function getApiModel(): ApiRoute;

    /** Получение всех существующих моделей по АПИ Get-запросу */
    public static function fromRequestGetAll(ApiGateway $apiGateway, int $maxLimitOfReturnedModels): array;

    /** Получение модели (используя ID модели) по АПИ Get-запросу */
    public static function fromRequestGetById(ApiGateway $apiGateway, int $id): static;

    /** Получения результата по Get-запросу для упертых людей, которые не хотят использовать Query Builder {@see \Otis22\VetmanagerRestApi\Query\Builder}
     * @param string $getParameters То, что после знака "?" в строке запроса. Например: 'client_id=133'
     */
    public static function fromRequestGetByParametersAsString(ApiGateway $apiGateway, string $getParameters): array;

    /** Реализация возможности прямого обращения по АПИ используя имя модели и результат Query Builder {@see \Otis22\VetmanagerRestApi\Query\Builder} */
    public static function fromRequestGetByQueryBuilder(ApiGateway $apiGateway, PagedQuery $pagedQuery, int $maxLimitOfReturnedModels): array;

    /** @param array{"totalCount": int, MODEL_NAME: array<int, array>} $arrayOfObjectsAsDecodedJsons Ключом второго элемента будет название модели (а в нем массивы с моделями) */
    public static function fromMultipleDecodedJsons(ApiGateway $apiGateway, array $arrayOfObjectsAsDecodedJsons): array;

    /** @param array<int, array> $arrayOfDtosContentsAsDecodedJsons Каждый элемент - непосредственное содержимое DTO. ['id' => 1, ...] */
    public static function fromMultipleInnerContentsOfDecodedJsons(ApiGateway $apiGateway, array $arrayOfDtosContentsAsDecodedJsons): array;
}
