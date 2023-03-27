<?php

namespace VetmanagerApiGateway\DAO\Interface;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\Enum\ApiRoute;
use Otis22\VetmanagerRestApi\Query\PagedQuery;

/** Интерфейс для классов DTO, поддерживающих прямые АПИ-запросы на сервера Ветменеджер */
interface AllConstructorsInterface
{
    public static function getApiModel(): ApiRoute;

    /** Реализация возможности прямого обращения по АПИ используя имя модели и ID */
    public static function fromRequestById(ApiGateway $apiGateway, int $id): static;

    /** Реализация возможности прямого обращения по АПИ используя имя модели и результат Builder {@see \Otis22\VetmanagerRestApi\Query\Builder}
     * @return static[]
     */
    public static function fromRequestByQueryBuilder(ApiGateway $apiGateway, PagedQuery $pagedQuery): array;

    /** @param array{"totalCount": int, MODEL_NAME: array<int, array>} $arrayOfObjectsAsDecodedJsons Ключом второго элемента будет название модели (а в нем массивы с моделями) */
    public static function fromMultipleDecodedJsons(ApiGateway $apiGateway, array $arrayOfObjectsAsDecodedJsons): array;

    /** @param array<int, array> $arrayOfDtosContentsAsDecodedJsons Каждый элемент - непосредственное содержимое DTO. ['id' => 1, ...] */
    public static function fromInnerContentsOfDecodedJsons(ApiGateway $apiGateway, array $arrayOfDtosContentsAsDecodedJsons): array;
}
