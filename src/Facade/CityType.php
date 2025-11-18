<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use Otis22\VetmanagerRestApi\Query\Builder;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade\Interface\AllRequestsInterface;

class CityType extends AbstractFacade implements AllRequestsInterface
{
    /** @return class-string<ActiveRecord\CityType\CityType> */
    public static function getBasicActiveRecord(): string
    {
        return ActiveRecord\CityType\CityType::class;
    }

    /** @inheritDoc */
    public function fromSingleModelAsArray(array $modelAsArray): ActiveRecord\CityType\CityType
    {
        return $this->activeRecordFactory->getFromSingleModelAsArray($modelAsArray, self::getBasicActiveRecord());
    }

    /** @inheritDoc
     * @return ActiveRecord\CityType\CityType[]
     */
    public function fromMultipleModelsAsArrays(array $modelsAsArray): array
    {
        return $this->activeRecordFactory->getFromMultipleModelsAsArray($modelsAsArray, self::getBasicActiveRecord());
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ?ActiveRecord\CityType\CityType
    {
        return $this->protectedGetById(ActiveRecord\CityType\CityType::class, $id);
    }

    /** @return ActiveRecord\CityType\CityType[]
     * @throws VetmanagerApiGatewayException
     */
    public function getAll(int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetAll(ActiveRecord\CityType\CityType::class, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\CityType\CityType[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByPagedQuery(PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetByPagedQuery(ActiveRecord\CityType\CityType::class, $pagedQuery, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\CityType\CityType[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByQueryBuilder(Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        return $this->protectedGetByQueryBuilder(ActiveRecord\CityType\CityType::class, $builder, $maxLimitOfReturnedModels, $pageNumber);
    }

    /** @return ActiveRecord\CityType\CityType[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByGetParametersAsString(string $getParameters): array
    {
        return $this->protectedGetByGetParametersAsString(ActiveRecord\CityType\CityType::class, $getParameters);
    }

    /** @throws VetmanagerApiGatewayException */
    public function getNewEmpty(): ActiveRecord\CityType\CityType
    {
        return $this->protectedGetNewEmpty();
    }

    /** @throws VetmanagerApiGatewayException */
    public function createNewUsingArray(array $modelAsArray): ActiveRecord\CityType\CityType
    {
        return $this->protectedCreateNewUsingArray($modelAsArray);
    }

    /** @throws VetmanagerApiGatewayException */
    public function updateUsingIdAndArray(int $id, array $modelAsArray): ActiveRecord\CityType\CityType
    {
        return $this->protectedUpdateUsingIdAndArray($id, $modelAsArray);
    }
}
