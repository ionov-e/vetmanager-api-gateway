<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use Otis22\VetmanagerRestApi\Query\Builder;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade\Interface\AllRequestsInterface;

class Pet extends AbstractFacade implements AllRequestsInterface
{
    static public function getBasicActiveRecord(): string
    {
        return ActiveRecord\Pet\PetOnly::class;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ActiveRecord\Pet\PetPlusOwnerAndTypeAndBreedAndColor
    {
        return $this->protectedGetById(ActiveRecord\Pet\PetPlusOwnerAndTypeAndBreedAndColor::class, $id);
    }

    /** @return ActiveRecord\Pet\PetPlusOwnerAndTypeAndBreedAndColor[]
     * @throws VetmanagerApiGatewayException
     */
    public function getAll(int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetAll(ActiveRecord\Pet\PetPlusOwnerAndTypeAndBreedAndColor::class, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\Pet\PetPlusOwnerAndTypeAndBreedAndColor[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByPagedQuery(PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetByPagedQuery(ActiveRecord\Pet\PetPlusOwnerAndTypeAndBreedAndColor::class, $pagedQuery, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\Pet\PetPlusOwnerAndTypeAndBreedAndColor[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByQueryBuilder(Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        return $this->protectedGetByQueryBuilder(ActiveRecord\Pet\PetPlusOwnerAndTypeAndBreedAndColor::class, $builder, $maxLimitOfReturnedModels, $pageNumber);
    }

    /** @return ActiveRecord\Pet\PetPlusOwnerAndTypeAndBreedAndColor[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByParametersAsString(string $getParameters): array
    {
        return $this->protectedGetByGetParametersAsString(ActiveRecord\Pet\PetPlusOwnerAndTypeAndBreedAndColor::class, $getParameters);
    }

    /** @throws VetmanagerApiGatewayException */
    public function getNewEmpty(): ActiveRecord\Pet\PetOnly
    {
        return $this->protectedGetNewEmpty();
    }

    /** @throws VetmanagerApiGatewayException */
    public function createNewUsingArray(array $modelAsArray): ActiveRecord\Pet\PetOnly
    {
        return $this->protectedCreateNewUsingArray($modelAsArray);
    }

    /** @throws VetmanagerApiGatewayException */
    public function updateUsingIdAndArray(int $id, array $modelAsArray): ActiveRecord\Pet\PetOnly
    {
        return $this->protectedUpdateUsingIdAndArray($id, $modelAsArray);
    }

    /** @return ActiveRecord\Pet\PetPlusOwnerAndTypeAndBreedAndColor[]
     * @throws VetmanagerApiGatewayException
     */
    public function getOnlyAliveByClientId(int $clientId): array
    {
        return $this->getByQueryBuilder(
            (new Builder())
                ->where('owner_id', (string)$$clientId)
                ->where('status', \VetmanagerApiGateway\DTO\Pet\StatusEnum::Alive->value)
        );
    }
}