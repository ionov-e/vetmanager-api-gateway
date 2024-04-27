<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use Otis22\VetmanagerRestApi\Query\Builder;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\ActiveRecord\Street\ListEnum;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade\Interface\AllRequestsInterface;

class PetType extends AbstractFacade implements AllRequestsInterface
{
    /** @return class-string<ActiveRecord\PetType\PetTypeOnly> */
    static public function getBasicActiveRecord(): string
    {
        return ActiveRecord\PetType\PetTypeOnly::class;
    }

    /** @inheritDoc */
    public function fromSingleModelAsArray(array $modelAsArray, ListEnum $activeRecord = ListEnum::Basic): ActiveRecord\PetType\AbstractPetType
    {
        return $this->activeRecordFactory->getFromSingleModelAsArray($modelAsArray, $activeRecord->value);
    }

    /** @inheritDoc
     * @return ActiveRecord\PetType\AbstractPetType[]
     */
    public function fromMultipleModelsAsArrays(array $modelsAsArray, ListEnum $activeRecord = ListEnum::Basic): array
    {
        return $this->activeRecordFactory->getFromMultipleModelsAsArray($modelsAsArray, $activeRecord->value);
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ?ActiveRecord\PetType\PetTypePlusBreeds
    {
        return $this->protectedGetById(ActiveRecord\PetType\PetTypePlusBreeds::class, $id);
    }

    /** @return ActiveRecord\PetType\PetTypePlusBreeds[]
     * @throws VetmanagerApiGatewayException
     */
    public function getAll(int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetAll(ActiveRecord\PetType\PetTypePlusBreeds::class, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\PetType\PetTypePlusBreeds[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByPagedQuery(PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetByPagedQuery(ActiveRecord\PetType\PetTypePlusBreeds::class, $pagedQuery, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\PetType\PetTypePlusBreeds[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByQueryBuilder(Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        return $this->protectedGetByQueryBuilder(ActiveRecord\PetType\PetTypePlusBreeds::class, $builder, $maxLimitOfReturnedModels, $pageNumber);
    }

    /** @return ActiveRecord\PetType\PetTypePlusBreeds[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByGetParametersAsString(string $getParameters): array
    {
        return $this->protectedGetByGetParametersAsString(ActiveRecord\PetType\PetTypePlusBreeds::class, $getParameters);
    }

    /** @throws VetmanagerApiGatewayException */
    public function getNewEmpty(): ActiveRecord\PetType\PetTypeOnly
    {
        return $this->protectedGetNewEmpty();
    }

    /** @throws VetmanagerApiGatewayException */
    public function createNewUsingArray(array $modelAsArray): ActiveRecord\PetType\PetTypeOnly
    {
        return $this->protectedCreateNewUsingArray($modelAsArray);
    }

    /** @throws VetmanagerApiGatewayException */
    public function updateUsingIdAndArray(int $id, array $modelAsArray): ActiveRecord\PetType\PetTypeOnly
    {
        return $this->protectedUpdateUsingIdAndArray($id, $modelAsArray);
    }
}