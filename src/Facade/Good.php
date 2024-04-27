<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use Otis22\VetmanagerRestApi\Query\Builder;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\ActiveRecord\Good\ListEnum;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade\Interface\AllRequestsInterface;

class Good extends AbstractFacade implements AllRequestsInterface
{
    /** @return class-string<ActiveRecord\Good\GoodOnly> */
    static public function getBasicActiveRecord(): string
    {
        return ActiveRecord\Good\GoodOnly::class;
    }

    /** @inheritDoc */
    public function fromSingleModelAsArray(array $modelAsArray, ListEnum $activeRecord = ListEnum::Basic): ActiveRecord\Good\AbstractGood
    {
        return $this->activeRecordFactory->getFromSingleModelAsArray($modelAsArray, $activeRecord->value);
    }

    /** @inheritDoc
     * @return ActiveRecord\Good\AbstractGood[]
     */
    public function fromMultipleModelsAsArrays(array $modelsAsArray, ListEnum $activeRecord = ListEnum::Basic): array
    {
        return $this->activeRecordFactory->getFromMultipleModelsAsArray($modelsAsArray, $activeRecord->value);
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ?ActiveRecord\Good\GoodPlusGroupAndUnitAndSaleParams
    {
        return $this->protectedGetById(ActiveRecord\Good\GoodPlusGroupAndUnitAndSaleParams::class, $id);
    }

    /** @return ActiveRecord\Good\GoodPlusGroupAndUnitAndSaleParams[]
     * @throws VetmanagerApiGatewayException
     */
    public function getAll(int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetAll(ActiveRecord\Good\GoodPlusGroupAndUnitAndSaleParams::class, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\Good\GoodPlusGroupAndUnitAndSaleParams[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByPagedQuery(PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetByPagedQuery(ActiveRecord\Good\GoodPlusGroupAndUnitAndSaleParams::class, $pagedQuery, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\Good\GoodPlusGroupAndUnitAndSaleParams[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByQueryBuilder(Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        return $this->protectedGetByQueryBuilder(ActiveRecord\Good\GoodPlusGroupAndUnitAndSaleParams::class, $builder, $maxLimitOfReturnedModels, $pageNumber);
    }

    /** @return ActiveRecord\Good\GoodPlusGroupAndUnitAndSaleParams[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByGetParametersAsString(string $getParameters): array
    {
        return $this->protectedGetByGetParametersAsString(ActiveRecord\Good\GoodPlusGroupAndUnitAndSaleParams::class, $getParameters);
    }

    /** @throws VetmanagerApiGatewayException */
    public function getNewEmpty(): ActiveRecord\Good\GoodOnly
    {
        return $this->protectedGetNewEmpty();
    }

    /** @throws VetmanagerApiGatewayException */
    public function createNewUsingArray(array $modelAsArray): ActiveRecord\Good\GoodOnly
    {
        return $this->protectedCreateNewUsingArray($modelAsArray);
    }

    /** @throws VetmanagerApiGatewayException */
    public function updateUsingIdAndArray(int $id, array $modelAsArray): ActiveRecord\Good\GoodOnly
    {
        return $this->protectedUpdateUsingIdAndArray($id, $modelAsArray);
    }
}