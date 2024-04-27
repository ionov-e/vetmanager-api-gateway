<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use Otis22\VetmanagerRestApi\Query\Builder;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\ActiveRecord\User\ListEnum;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade\Interface\AllRequestsInterface;

class User extends AbstractFacade implements AllRequestsInterface
{
    /** @return class-string<ActiveRecord\User\UserOnly> */
    static public function getBasicActiveRecord(): string
    {
        return ActiveRecord\User\UserOnly::class;
    }

    /** @inheritDoc */
    public function fromSingleModelAsArray(array $modelAsArray, ListEnum $activeRecord = ListEnum::Basic): ActiveRecord\User\AbstractUser
    {
        return $this->activeRecordFactory->getFromSingleModelAsArray($modelAsArray, $activeRecord->value);
    }

    /** @inheritDoc
     * @return ActiveRecord\User\AbstractUser[]
     */
    public function fromMultipleModelsAsArrays(array $modelsAsArray, ListEnum $activeRecord = ListEnum::Basic): array
    {
        return $this->activeRecordFactory->getFromMultipleModelsAsArray($modelsAsArray, $activeRecord->value);
    }


    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ?ActiveRecord\User\UserPlusPositionAndRole
    {
        return $this->protectedGetById(ActiveRecord\User\UserPlusPositionAndRole::class, $id);
    }

    /** @return ActiveRecord\User\UserPlusPositionAndRole[]
     * @throws VetmanagerApiGatewayException
     */
    public function getAll(int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetAll(ActiveRecord\User\UserPlusPositionAndRole::class, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\User\UserPlusPositionAndRole[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByPagedQuery(PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetByPagedQuery(ActiveRecord\User\UserPlusPositionAndRole::class, $pagedQuery, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\User\UserPlusPositionAndRole[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByQueryBuilder(Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        return $this->protectedGetByQueryBuilder(ActiveRecord\User\UserPlusPositionAndRole::class, $builder, $maxLimitOfReturnedModels, $pageNumber);
    }

    /** @return ActiveRecord\User\UserPlusPositionAndRole[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByGetParametersAsString(string $getParameters): array
    {
        return $this->protectedGetByGetParametersAsString(ActiveRecord\User\UserPlusPositionAndRole::class, $getParameters);
    }

    /** @throws VetmanagerApiGatewayException */
    public function getNewEmpty(): ActiveRecord\User\UserOnly
    {
        return $this->protectedGetNewEmpty();
    }

    /** @throws VetmanagerApiGatewayException */
    public function createNewUsingArray(array $modelAsArray): ActiveRecord\User\UserOnly
    {
        return $this->protectedCreateNewUsingArray($modelAsArray);
    }

    /** @throws VetmanagerApiGatewayException */
    public function updateUsingIdAndArray(int $id, array $modelAsArray): ActiveRecord\User\UserOnly
    {
        return $this->protectedUpdateUsingIdAndArray($id, $modelAsArray);
    }
}