<?php

namespace VetmanagerApiGateway\DO\DTO\DAO\Interface;

use Otis22\VetmanagerRestApi\Query\Builder;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use VetmanagerApiGateway\ApiGateway;

interface RequestGetByQueryInterface extends BasicDAOInterface
{
    /** Реализация возможности прямого обращения по АПИ, формируя фильтры/сортировку/лимит с помощью с Query Builder
     *
     * Пример работы с Query Builder: (new Builder())->where('clinic_id', (string)$clinicId)->orderBy('property_name','desc')*/
    public static function getByQueryBuilder(ApiGateway $apiGateway, Builder $builder, int $maxLimitOfReturnedModels, int $pageNumber): array;

    /** Реализация возможности прямого обращения по АПИ, формируя фильтры/сортировку/лимит с помощью PagedQuery (результат вызова методов Query Builder):
     * {@see Builder::top()}, {@see Builder::paginate()}, {@see Builder::paginateAll()}).
     *
     * Пример получения PagedQuery: (new Builder())->where('clinic_id', (string)$clinicId)->orderBy('property_name','desc')->top(10)
     */
    public static function getByPagedQuery(ApiGateway $apiGateway, PagedQuery $pagedQuery, int $maxLimitOfReturnedModels): array;

    /** Получения результата по Get-запросу для упертых людей, которые не хотят использовать Query Builder {@see Builder}
     * @param string $getParameters То, что после знака "?" в строке запроса. Например: 'client_id=133'
     */
    public static function getByParametersAsString(ApiGateway $apiGateway, string $getParameters): array;
}
