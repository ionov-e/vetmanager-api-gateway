<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use Otis22\VetmanagerRestApi\Query\Builder;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\ActiveRecord\Client\ClientPlusTypeAndCity;
use VetmanagerApiGateway\ActiveRecord\Client\ListEnum;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade\Interface\AllRequestsInterface;

class Client extends AbstractFacade implements AllRequestsInterface
{

    /** @return class-string<ActiveRecord\Client\ClientOnly> */
    public static function getBasicActiveRecord(): string
    {
        return ActiveRecord\Client\ClientOnly::class;
    }

    /** @inheritDoc */
    public function fromSingleModelAsArray(array $modelAsArray, ListEnum $activeRecord = ListEnum::Basic): ActiveRecord\Client\AbstractClient
    {
        return $this->activeRecordFactory->getFromSingleModelAsArray($modelAsArray, $activeRecord->value);
    }

    /** @inheritDoc
     * @return ActiveRecord\Client\AbstractClient[]
     */
    public function fromMultipleModelsAsArrays(array $modelsAsArray, ListEnum $activeRecord = ListEnum::Basic): array
    {
        return $this->activeRecordFactory->getFromMultipleModelsAsArray($modelsAsArray, $activeRecord->value);
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ClientPlusTypeAndCity
    {
        return $this->protectedGetById(ClientPlusTypeAndCity::class, $id);
    }

    /** @return ClientPlusTypeAndCity[]
     * @throws VetmanagerApiGatewayException
     */
    public function getAll(int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetAll(ClientPlusTypeAndCity::class, $maxLimitOfReturnedModels);
    }

    /** @return ClientPlusTypeAndCity[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByPagedQuery(PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetByPagedQuery(ClientPlusTypeAndCity::class, $pagedQuery, $maxLimitOfReturnedModels);
    }

    /** @return ClientPlusTypeAndCity[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByQueryBuilder(Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        return $this->protectedGetByQueryBuilder(ClientPlusTypeAndCity::class, $builder, $maxLimitOfReturnedModels, $pageNumber);
    }

    /** @return ClientPlusTypeAndCity[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByParametersAsString(string $getParameters): array
    {
        return $this->protectedGetByGetParametersAsString(ClientPlusTypeAndCity::class, $getParameters);
    }

    /** @throws VetmanagerApiGatewayException */
    public function getNewEmpty(): ActiveRecord\Client\ClientOnly
    {
        return $this->protectedGetNewEmpty();
    }

    /** @throws VetmanagerApiGatewayException */
    public function createNewUsingArray(array $modelAsArray): ActiveRecord\Client\ClientOnly
    {
        return $this->protectedCreateNewUsingArray($modelAsArray);
    }

    /** @throws VetmanagerApiGatewayException */
    public function updateUsingIdAndArray(int $id, array $modelAsArray): ActiveRecord\Client\ClientOnly
    {
        return $this->protectedUpdateUsingIdAndArray($id, $modelAsArray);
    }
}