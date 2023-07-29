<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use Otis22\VetmanagerRestApi\Query\Builder;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\ActiveRecord\Client\ClientPlusTypeAndCity;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Facade\Interface\AllRequestsInterface;

class Client extends AbstractFacade implements AllRequestsInterface
{
    public static function getBasicActiveRecord(): string
    {
        return ActiveRecord\Client\ClientOnly::class;
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
        return $this->activeRecordFactory->getEmpty(ActiveRecord\Client\ClientOnly::class);
    }

    /** @throws VetmanagerApiGatewayException */
    public function createNewUsingArray(array $modelAsArray): ActiveRecord\Client\ClientOnly
    {
        return $this->protectedCreateNewUsingArray(ActiveRecord\Client\ClientOnly::class, $modelAsArray);
    }

    /** @throws VetmanagerApiGatewayException */
    public function updateUsingIdAndArray(int $id, array $modelAsArray): ActiveRecord\Client\ClientOnly
    {
        return $this->protectedUpdateUsingIdAndArray(ActiveRecord\Client\ClientOnly::class, $id, $modelAsArray);
    }
}