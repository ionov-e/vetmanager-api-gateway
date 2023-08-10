<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use Otis22\VetmanagerRestApi\Query\Builder;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade\Interface\AllRequestsInterface;

class GoodGroup extends AbstractFacade implements AllRequestsInterface
{
    /** @return class-string<ActiveRecord\GoodGroup\GoodGroup> */
    static public function getBasicActiveRecord(): string
    {
        return ActiveRecord\GoodGroup\GoodGroup::class;
    }

    /** @inheritDoc */
    public function fromSingleModelAsArray(array $modelAsArray): ActiveRecord\GoodGroup\GoodGroup
    {
        return $this->activeRecordFactory->getFromSingleModelAsArray($modelAsArray, self::getBasicActiveRecord());
    }

    /** @inheritDoc
     * @return ActiveRecord\GoodGroup\GoodGroup[]
     */
    public function fromMultipleModelsAsArrays(array $modelsAsArray): array
    {
        return $this->activeRecordFactory->getFromMultipleModelsAsArray($modelsAsArray, self::getBasicActiveRecord());
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ActiveRecord\GoodGroup\GoodGroup
    {
        return $this->protectedGetById(self::getBasicActiveRecord(), $id);
    }
    /** @return ActiveRecord\GoodGroup\GoodGroup[]
     * @throws VetmanagerApiGatewayException
     */
    public function getAll(int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetAll(ActiveRecord\GoodGroup\GoodGroup::class, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\GoodGroup\GoodGroup[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByPagedQuery(PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetByPagedQuery(ActiveRecord\GoodGroup\GoodGroup::class, $pagedQuery, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\GoodGroup\GoodGroup[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByQueryBuilder(Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        return $this->protectedGetByQueryBuilder(ActiveRecord\GoodGroup\GoodGroup::class, $builder, $maxLimitOfReturnedModels, $pageNumber);
    }

    /** @return ActiveRecord\GoodGroup\GoodGroup[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByGetParametersAsString(string $getParameters): array
    {
        return $this->protectedGetByGetParametersAsString(ActiveRecord\GoodGroup\GoodGroup::class, $getParameters);
    }

    /** @throws VetmanagerApiGatewayException */
    public function getNewEmpty(): ActiveRecord\GoodGroup\GoodGroup
    {
        return $this->protectedGetNewEmpty();
    }

    /** @throws VetmanagerApiGatewayException */
    public function createNewUsingArray(array $modelAsArray): ActiveRecord\GoodGroup\GoodGroup
    {
        return $this->protectedCreateNewUsingArray($modelAsArray);
    }

    /** @throws VetmanagerApiGatewayException */
    public function updateUsingIdAndArray(int $id, array $modelAsArray): ActiveRecord\GoodGroup\GoodGroup
    {
        return $this->protectedUpdateUsingIdAndArray($id, $modelAsArray);
    }
}