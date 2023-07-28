<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use Otis22\VetmanagerRestApi\Query\Builder;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use VetmanagerApiGateway\ActiveRecord;
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
    public function getById(int $id): ActiveRecord\Client\ClientPlusTypeAndCity
    {
        return $this->protectedGetById(ActiveRecord\Client\ClientPlusTypeAndCity::class, $id);
    }

    /** @return \VetmanagerApiGateway\ActiveRecord\Client\ClientPlusTypeAndCity[]
     * @throws VetmanagerApiGatewayException
     */
    public function getAll(int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetAll(ActiveRecord\Client\ClientPlusTypeAndCity::class, $maxLimitOfReturnedModels);
    }

    /** @return \VetmanagerApiGateway\ActiveRecord\Client\ClientPlusTypeAndCity[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByPagedQuery(PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetByPagedQuery(ActiveRecord\Client\ClientPlusTypeAndCity::class, $pagedQuery, $maxLimitOfReturnedModels);
    }

    /** @return \VetmanagerApiGateway\ActiveRecord\Client\ClientPlusTypeAndCity[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByQueryBuilder(Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        return $this->protectedGetByQueryBuilder(ActiveRecord\Client\ClientPlusTypeAndCity::class, $builder, $maxLimitOfReturnedModels, $pageNumber);
    }

    /** @inheritDoc
     * @throws VetmanagerApiGatewayException
     */
    public function getByParametersAsString(string $getParameters): array
    {
        return $this->protectedGetByGetParametersAsString(ActiveRecord\Client\ClientPlusTypeAndCity::class, $getParameters);
    }

    /** @inheritDoc
     * @throws VetmanagerApiGatewayInnerException
     */
    public function getNewEmpty(): ActiveRecord\Client\ClientOnly
    {
        return $this->activeRecordFactory->getEmpty(ActiveRecord\Client\ClientOnly::class);
    }

    /** @inheritDoc
     * @throws VetmanagerApiGatewayException
     */
    public function createNewUsingArray(array $modelAsArray): ActiveRecord\Client\ClientOnly
    {
        return $this->protectedCreateNewUsingArray(ActiveRecord\Client\ClientOnly::class, $modelAsArray);
    }

    /** @inheritDoc
     * @throws VetmanagerApiGatewayException
     */
    public function updateUsingIdAndArray(int $id, array $modelAsArray): ActiveRecord\Client\ClientOnly
    {
        return $this->protectedUpdateUsingIdAndArray(ActiveRecord\Client\ClientOnly::class, $id, $modelAsArray);
    }
}