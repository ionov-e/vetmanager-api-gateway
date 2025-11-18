<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use Otis22\VetmanagerRestApi\Query\Builder;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade\Interface\AllRequestsInterface;

class MedicalCard extends AbstractFacade implements AllRequestsInterface
{
    /** @return class-string<ActiveRecord\MedicalCard\MedicalCardOnly> */
    public static function getBasicActiveRecord(): string
    {
        return ActiveRecord\MedicalCard\MedicalCardOnly::class;
    }

    /** @inheritDoc */
    public function fromSingleModelAsArray(array $modelAsArray): ActiveRecord\MedicalCard\AbstractMedicalCard
    {
        return $this->activeRecordFactory->getFromSingleModelAsArray($modelAsArray, self::getBasicActiveRecord());
    }

    /** @inheritDoc
     * @return ActiveRecord\MedicalCard\AbstractMedicalCard[]
     */
    public function fromMultipleModelsAsArrays(array $modelsAsArray): array
    {
        return $this->activeRecordFactory->getFromMultipleModelsAsArray($modelsAsArray, self::getBasicActiveRecord());
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ?ActiveRecord\MedicalCard\MedicalCardPlusPet
    {
        return $this->protectedGetById(ActiveRecord\MedicalCard\MedicalCardPlusPet::class, $id);
    }

    /** @return ActiveRecord\MedicalCard\MedicalCardPlusPet[]
     * @throws VetmanagerApiGatewayException
     */
    public function getAll(int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetAll(ActiveRecord\MedicalCard\MedicalCardPlusPet::class, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\MedicalCard\MedicalCardPlusPet[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByPagedQuery(PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetByPagedQuery(ActiveRecord\MedicalCard\MedicalCardPlusPet::class, $pagedQuery, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\MedicalCard\MedicalCardPlusPet[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByQueryBuilder(Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        return $this->protectedGetByQueryBuilder(ActiveRecord\MedicalCard\MedicalCardPlusPet::class, $builder, $maxLimitOfReturnedModels, $pageNumber);
    }

    /** @return ActiveRecord\MedicalCard\MedicalCardPlusPet[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByGetParametersAsString(string $getParameters): array
    {
        return $this->protectedGetByGetParametersAsString(ActiveRecord\MedicalCard\MedicalCardPlusPet::class, $getParameters);
    }

    /** @throws VetmanagerApiGatewayException */
    public function getNewEmpty(): ActiveRecord\MedicalCard\MedicalCardOnly
    {
        return $this->protectedGetNewEmpty();
    }

    /** @throws VetmanagerApiGatewayException */
    public function createNewUsingArray(array $modelAsArray): ActiveRecord\MedicalCard\MedicalCardOnly
    {
        return $this->protectedCreateNewUsingArray($modelAsArray);
    }

    /** @throws VetmanagerApiGatewayException */
    public function updateUsingIdAndArray(int $id, array $modelAsArray): ActiveRecord\MedicalCard\MedicalCardOnly
    {
        return $this->protectedUpdateUsingIdAndArray($id, $modelAsArray);
    }
}
