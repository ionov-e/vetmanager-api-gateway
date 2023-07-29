<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use Otis22\VetmanagerRestApi\Query\Builder;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\ActiveRecord\Client\ActiveRecord\Breed\BreedOnly;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade\Interface\AllRequestsInterface;

class Breed extends AbstractFacade implements AllRequestsInterface
{
    static public function getBasicActiveRecord(): string
    {
        return ActiveRecord\Breed\BreedOnly::class;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ActiveRecord\Breed\BreedPlusPetType
    {
        return $this->protectedGetById(ActiveRecord\Breed\BreedPlusPetType::class, $id);
    }

    /** @return ActiveRecord\Breed\BreedOnly[]
     * @throws VetmanagerApiGatewayException
     */
    public function getAll(int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetAll(ActiveRecord\Breed\BreedOnly::class, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\Breed\BreedOnly[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByPagedQuery(PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetByPagedQuery(ActiveRecord\Breed\BreedOnly::class, $pagedQuery, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\Breed\BreedOnly[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByQueryBuilder(Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        return $this->protectedGetByQueryBuilder(ActiveRecord\Breed\BreedOnly::class, $builder, $maxLimitOfReturnedModels, $pageNumber);
    }

    /** @return ActiveRecord\Breed\BreedOnly[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByParametersAsString(string $getParameters): array
    {
        return $this->protectedGetByGetParametersAsString(ActiveRecord\Breed\BreedOnly::class, $getParameters);
    }

    /** @throws VetmanagerApiGatewayException */
    public function getNewEmpty(): ActiveRecord\Breed\BreedOnly
    {
        return $this->activeRecordFactory->getEmpty(ActiveRecord\Breed\BreedOnly::class);
    }

    /** @throws VetmanagerApiGatewayException */
    public function createNewUsingArray(array $modelAsArray): ActiveRecord\Breed\BreedOnly
    {
        return $this->protectedCreateNewUsingArray(ActiveRecord\Breed\BreedOnly::class, $modelAsArray);
    }

    /** @throws VetmanagerApiGatewayException */
    public function updateUsingIdAndArray(int $id, array $modelAsArray): ActiveRecord\Breed\BreedOnly
    {
        return $this->protectedUpdateUsingIdAndArray(ActiveRecord\Breed\BreedOnly::class, $id, $modelAsArray);
    }
}