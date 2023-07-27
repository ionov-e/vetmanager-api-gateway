<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use Otis22\VetmanagerRestApi\Query\Builder;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Facade\Interface\AllRequestsInterface;

class Client extends AbstractFacade implements AllRequestsInterface
{
    public static function getDefaultActiveRecord(): string
    {
        return ActiveRecord\Client::class;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ActiveRecord\ClientPlusTypeAndCity
    {
        return $this->protectedGetById(ActiveRecord\ClientPlusTypeAndCity::class, $id);
    }

    /** @return ActiveRecord\ClientPlusTypeAndCity[]
     * @throws VetmanagerApiGatewayException
     */
    public function getAll(int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetAll(ActiveRecord\ClientPlusTypeAndCity::class, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\ClientPlusTypeAndCity[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByPagedQuery(PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetByPagedQuery(ActiveRecord\ClientPlusTypeAndCity::class, $pagedQuery, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\ClientPlusTypeAndCity[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByQueryBuilder(Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        return $this->protectedGetByQueryBuilder(ActiveRecord\ClientPlusTypeAndCity::class, $builder, $maxLimitOfReturnedModels, $pageNumber);
    }

    /** @inheritDoc
     * @throws VetmanagerApiGatewayException
     */
    public function getByParametersAsString(string $getParameters): array
    {
        return $this->protectedGetByGetParametersAsString(ActiveRecord\ClientPlusTypeAndCity::class, $getParameters);
    }

    /** @inheritDoc
     * @throws VetmanagerApiGatewayInnerException
     */
    public function getNewEmpty(): ActiveRecord\Client
    {
        return $this->activeRecordFactory->getEmpty(ActiveRecord\Client::class);
    }

    /** @inheritDoc */
    public function createNewUsingArray(array $modelAsArray): ActiveRecord\Client
    {
        // TODO: Implement createNewUsingArray() method.
    }

    /** @inheritDoc */
    public function updateUsingIdAndArray(int $id, array $data): AbstractActiveRecord
    {
        // TODO: Implement updateUsingIdAndArray() method.
    }
}