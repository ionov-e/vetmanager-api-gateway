<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use Otis22\VetmanagerRestApi\Query\Builder;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\ActiveRecord\Admission\AdmissionPlusClientAndPetAndInvoices;
use VetmanagerApiGateway\ActiveRecord\Breed\AbstractBreed;
use VetmanagerApiGateway\ActiveRecord\Breed\ListEnum;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade\Interface\AllRequestsInterface;

class Breed extends AbstractFacade implements AllRequestsInterface
{
    /** @return class-string<ActiveRecord\Breed\BreedOnly> */
    static public function getBasicActiveRecord(): string
    {
        return ActiveRecord\Breed\BreedOnly::class;
    }

    /** @inheritDoc */
    public function fromSingleModelAsArray(array $modelAsArray, ListEnum $activeRecord = ListEnum::Basic): AbstractBreed
    {
        return $this->activeRecordFactory->getFromSingleModelAsArray($modelAsArray, $activeRecord->value);
    }

    /** @inheritDoc
     * @return AbstractBreed[]
     */
    public function fromMultipleModelsAsArrays(array $modelsAsArray, ListEnum $activeRecord = ListEnum::Basic): array
    {
        return $this->activeRecordFactory->getFromMultipleModelsAsArray($modelsAsArray, $activeRecord->value);
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ActiveRecord\Breed\BreedPlusPetType
    {
        return $this->protectedGetById(ActiveRecord\Breed\BreedPlusPetType::class, $id);
    }

    /** @return ActiveRecord\Breed\BreedPlusPetType[]
     * @throws VetmanagerApiGatewayException
     */
    public function getAll(int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetAll(ActiveRecord\Breed\BreedPlusPetType::class, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\Breed\BreedPlusPetType[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByPagedQuery(PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetByPagedQuery(ActiveRecord\Breed\BreedPlusPetType::class, $pagedQuery, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\Breed\BreedPlusPetType[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByQueryBuilder(Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        return $this->protectedGetByQueryBuilder(ActiveRecord\Breed\BreedPlusPetType::class, $builder, $maxLimitOfReturnedModels, $pageNumber);
    }

    /** @return ActiveRecord\Breed\BreedPlusPetType[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByGetParametersAsString(string $getParameters): array
    {
        return $this->protectedGetByGetParametersAsString(ActiveRecord\Breed\BreedPlusPetType::class, $getParameters);
    }

    /** @throws VetmanagerApiGatewayException */
    public function getNewEmpty(): ActiveRecord\Breed\BreedOnly
    {
        return $this->protectedGetNewEmpty();
    }

    /** @throws VetmanagerApiGatewayException */
    public function createNewUsingArray(array $modelAsArray): ActiveRecord\Breed\BreedOnly
    {
        return $this->protectedCreateNewUsingArray($modelAsArray);
    }

    /** @throws VetmanagerApiGatewayException */
    public function updateUsingIdAndArray(int $id, array $modelAsArray): ActiveRecord\Breed\BreedOnly
    {
        return $this->protectedUpdateUsingIdAndArray($id, $modelAsArray);
    }

    /**
     * @return AdmissionPlusClientAndPetAndInvoices[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByPetTypeId(int $petTypeId, int $maxLimit = 100): array
    {
        return $this->getByQueryBuilder(
            (new Builder())->where('pet_type_id', (string)$petTypeId),
            $maxLimit
        );
    }
}