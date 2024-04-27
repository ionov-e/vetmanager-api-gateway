<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use Otis22\VetmanagerRestApi\Query\Builder;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade\Interface\AllRequestsInterface;

class UserPosition extends AbstractFacade implements AllRequestsInterface
{
    /** @return class-string<ActiveRecord\UserPosition\UserPosition> */
    static public function getBasicActiveRecord(): string
    {
        return ActiveRecord\UserPosition\UserPosition::class;
    }

    /** @inheritDoc */
    public function fromSingleModelAsArray(array $modelAsArray): ActiveRecord\UserPosition\UserPosition
    {
        return $this->activeRecordFactory->getFromSingleModelAsArray($modelAsArray, self::getBasicActiveRecord());
    }

    /** @inheritDoc
     * @return ActiveRecord\UserPosition\UserPosition[]
     */
    public function fromMultipleModelsAsArrays(array $modelsAsArray): array
    {
        return $this->activeRecordFactory->getFromMultipleModelsAsArray($modelsAsArray, self::getBasicActiveRecord());
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ?ActiveRecord\UserPosition\UserPosition
    {
        return $this->protectedGetById(ActiveRecord\UserPosition\UserPosition::class, $id);
    }

    /** @return ActiveRecord\UserPosition\UserPosition[]
     * @throws VetmanagerApiGatewayException
     */
    public function getAll(int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetAll(ActiveRecord\UserPosition\UserPosition::class, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\UserPosition\UserPosition[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByPagedQuery(PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetByPagedQuery(ActiveRecord\UserPosition\UserPosition::class, $pagedQuery, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\UserPosition\UserPosition[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByQueryBuilder(Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        return $this->protectedGetByQueryBuilder(ActiveRecord\UserPosition\UserPosition::class, $builder, $maxLimitOfReturnedModels, $pageNumber);
    }

    /** @return ActiveRecord\UserPosition\UserPosition[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByGetParametersAsString(string $getParameters): array
    {
        return $this->protectedGetByGetParametersAsString(ActiveRecord\UserPosition\UserPosition::class, $getParameters);
    }

    /** @throws VetmanagerApiGatewayException */
    public function getNewEmpty(): ActiveRecord\UserPosition\UserPosition
    {
        return $this->protectedGetNewEmpty();
    }

    /** @throws VetmanagerApiGatewayException */
    public function createNewUsingArray(array $modelAsArray): ActiveRecord\UserPosition\UserPosition
    {
        return $this->protectedCreateNewUsingArray($modelAsArray);
    }

    /** @throws VetmanagerApiGatewayException */
    public function updateUsingIdAndArray(int $id, array $modelAsArray): ActiveRecord\UserPosition\UserPosition
    {
        return $this->protectedUpdateUsingIdAndArray($id, $modelAsArray);
    }
}