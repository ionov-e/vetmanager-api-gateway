<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use Otis22\VetmanagerRestApi\Query\Builder;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade\Interface\AllRequestsInterface;

class GoodSaleParam extends AbstractFacade implements AllRequestsInterface
{
    /** @return class-string<ActiveRecord\GoodSaleParam\GoodSaleParamOnly> */
    public static function getBasicActiveRecord(): string
    {
        return ActiveRecord\GoodSaleParam\GoodSaleParamOnly::class;
    }

    /** @inheritDoc */
    public function fromSingleModelAsArray(array $modelAsArray): ActiveRecord\GoodSaleParam\AbstractGoodSaleParam
    {
        return $this->activeRecordFactory->getFromSingleModelAsArray($modelAsArray, self::getBasicActiveRecord());
    }

    /** @inheritDoc
     * @return ActiveRecord\GoodSaleParam\AbstractGoodSaleParam[]
     */
    public function fromMultipleModelsAsArrays(array $modelsAsArray): array
    {
        return $this->activeRecordFactory->getFromMultipleModelsAsArray($modelsAsArray, self::getBasicActiveRecord());
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ?ActiveRecord\GoodSaleParam\GoodSaleParamPlusUnitAndGood
    {
        return $this->protectedGetById(ActiveRecord\GoodSaleParam\GoodSaleParamPlusUnitAndGood::class, $id);
    }

    /** @return ActiveRecord\GoodSaleParam\GoodSaleParamPlusUnitAndGood[]
     * @throws VetmanagerApiGatewayException
     */
    public function getAll(int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetAll(ActiveRecord\GoodSaleParam\GoodSaleParamPlusUnitAndGood::class, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\GoodSaleParam\GoodSaleParamPlusUnitAndGood[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByPagedQuery(PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetByPagedQuery(ActiveRecord\GoodSaleParam\GoodSaleParamPlusUnitAndGood::class, $pagedQuery, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\GoodSaleParam\GoodSaleParamPlusUnitAndGood[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByQueryBuilder(Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        return $this->protectedGetByQueryBuilder(ActiveRecord\GoodSaleParam\GoodSaleParamPlusUnitAndGood::class, $builder, $maxLimitOfReturnedModels, $pageNumber);
    }

    /** @return ActiveRecord\GoodSaleParam\GoodSaleParamPlusUnitAndGood[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByGetParametersAsString(string $getParameters): array
    {
        return $this->protectedGetByGetParametersAsString(ActiveRecord\GoodSaleParam\GoodSaleParamPlusUnitAndGood::class, $getParameters);
    }

    /** @throws VetmanagerApiGatewayException */
    public function getNewEmpty(): ActiveRecord\GoodSaleParam\GoodSaleParamOnly
    {
        return $this->protectedGetNewEmpty();
    }

    /** @throws VetmanagerApiGatewayException */
    public function createNewUsingArray(array $modelAsArray): ActiveRecord\GoodSaleParam\GoodSaleParamOnly
    {
        return $this->protectedCreateNewUsingArray($modelAsArray);
    }

    /** @throws VetmanagerApiGatewayException */
    public function updateUsingIdAndArray(int $id, array $modelAsArray): ActiveRecord\GoodSaleParam\GoodSaleParamOnly
    {
        return $this->protectedUpdateUsingIdAndArray($id, $modelAsArray);
    }
}
