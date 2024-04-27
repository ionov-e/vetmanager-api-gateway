<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use Otis22\VetmanagerRestApi\Query\Builder;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade\Interface\AllRequestsInterface;

class CassaClose extends AbstractFacade implements AllRequestsInterface
{
    /** @return class-string<ActiveRecord\CassaClose\CassaCloseOnly> */
    public static function getBasicActiveRecord(): string
    {
        return ActiveRecord\CassaClose\CassaCloseOnly::class;
    }

    /** @inheritDoc */
    public function fromSingleModelAsArray(array $modelAsArray): ActiveRecord\CassaClose\CassaCloseOnly
    {
        return $this->activeRecordFactory->getFromSingleModelAsArray($modelAsArray, self::getBasicActiveRecord());
    }

    /** @inheritDoc
     * @return ActiveRecord\CassaClose\AbstractCassaClose[]
     */
    public function fromMultipleModelsAsArrays(array $modelsAsArray): array
    {
        return $this->activeRecordFactory->getFromMultipleModelsAsArray($modelsAsArray, self::getBasicActiveRecord());
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ?ActiveRecord\CassaClose\AbstractCassaClose
    {
        return $this->protectedGetById(self::getBasicActiveRecord(), $id);
    }

    /** @return ActiveRecord\CassaClose\AbstractCassaClose[]
     * @throws VetmanagerApiGatewayException
     */
    public function getAll(int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetAll(ActiveRecord\CassaClose\AbstractCassaClose::class, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\CassaClose\AbstractCassaClose[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByPagedQuery(PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetByPagedQuery(ActiveRecord\CassaClose\AbstractCassaClose::class, $pagedQuery, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\CassaClose\AbstractCassaClose[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByQueryBuilder(Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        return $this->protectedGetByQueryBuilder(ActiveRecord\CassaClose\AbstractCassaClose::class, $builder, $maxLimitOfReturnedModels, $pageNumber);
    }

    /** @return ActiveRecord\CassaClose\AbstractCassaClose[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByGetParametersAsString(string $getParameters): array
    {
        return $this->protectedGetByGetParametersAsString(ActiveRecord\CassaClose\AbstractCassaClose::class, $getParameters);
    }

    /** @throws VetmanagerApiGatewayException */
    public function getNewEmpty(): ActiveRecord\CassaClose\CassaCloseOnly
    {
        return $this->protectedGetNewEmpty();
    }

    /** @throws VetmanagerApiGatewayException */
    public function createNewUsingArray(array $modelAsArray): ActiveRecord\CassaClose\AbstractCassaClose
    {
        return $this->protectedCreateNewUsingArray($modelAsArray);
    }

    /** @throws VetmanagerApiGatewayException */
    public function updateUsingIdAndArray(int $id, array $modelAsArray): ActiveRecord\CassaClose\AbstractCassaClose
    {
        return $this->protectedUpdateUsingIdAndArray($id, $modelAsArray);
    }
}