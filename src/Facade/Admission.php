<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use Otis22\VetmanagerRestApi\Query\Builder;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\ActiveRecord\Admission\AbstractAdmission;
use VetmanagerApiGateway\ActiveRecord\Admission\AdmissionPlusClientAndPetAndInvoices;
use VetmanagerApiGateway\ActiveRecord\Admission\ListEnum;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade\Interface\AllRequestsInterface;

class Admission extends AbstractFacade implements AllRequestsInterface
{
    /** @return class-string<ActiveRecord\Admission\AdmissionOnly> */
    public static function getBasicActiveRecord(): string
    {
        return ActiveRecord\Admission\AdmissionOnly::class;
    }

    /** @inheritDoc */
    public function fromSingleModelAsArray(array $modelAsArray, ListEnum $activeRecord = ListEnum::Basic): AbstractAdmission
    {
        return $this->activeRecordFactory->getFromSingleModelAsArray($modelAsArray, $activeRecord->value);
    }

    /** @inheritDoc
     * @return AbstractAdmission[]
     */
    public function fromMultipleModelsAsArrays(array $modelsAsArray, ListEnum $activeRecord = ListEnum::Basic): array
    {
        return $this->activeRecordFactory->getFromMultipleModelsAsArray($modelsAsArray, $activeRecord->value);
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ?ActiveRecord\Admission\AdmissionPlusClientAndPetAndInvoicesAndTypeAndUser
    {
        return $this->protectedGetById(ActiveRecord\Admission\AdmissionPlusClientAndPetAndInvoicesAndTypeAndUser::class, $id);
    }

    /**
     * @return AdmissionPlusClientAndPetAndInvoices[]
     * @throws VetmanagerApiGatewayException
     */
    public function getAll(int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetAll(AdmissionPlusClientAndPetAndInvoices::class, $maxLimitOfReturnedModels);
    }

    /**
     * @return AdmissionPlusClientAndPetAndInvoices[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByPagedQuery(PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetByPagedQuery(AdmissionPlusClientAndPetAndInvoices::class, $pagedQuery, $maxLimitOfReturnedModels);
    }

    /** @return AdmissionPlusClientAndPetAndInvoices[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByQueryBuilder(Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        return $this->protectedGetByQueryBuilder(AdmissionPlusClientAndPetAndInvoices::class, $builder, $maxLimitOfReturnedModels, $pageNumber);
    }

    /** @throws VetmanagerApiGatewayException */
    public function getByGetParametersAsString(string $getParameters): array
    {
        return $this->protectedGetByGetParametersAsString(AdmissionPlusClientAndPetAndInvoices::class, $getParameters);
    }

    /** @throws VetmanagerApiGatewayException */
    public function getNewEmpty(): ActiveRecord\Admission\AdmissionOnly
    {
        return $this->protectedGetNewEmpty();
    }

    /** @throws VetmanagerApiGatewayException */
    public function createNewUsingArray(array $modelAsArray): ActiveRecord\Admission\AdmissionOnly
    {
        return $this->protectedCreateNewUsingArray($modelAsArray);
    }

    /** @throws VetmanagerApiGatewayException */
    public function updateUsingIdAndArray(int $id, array $modelAsArray): ActiveRecord\Admission\AdmissionOnly
    {
        return $this->protectedUpdateUsingIdAndArray($id, $modelAsArray);
    }


    /** Не возвращаются со статусом "удален"
     * @return AdmissionPlusClientAndPetAndInvoices[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByClientId(int $clientId, int $maxLimit = 100): array
    {
        return $this->getByQueryBuilder(
            (new Builder())
                ->where('client_id', (string)$clientId)
                ->where('status', '!=', 'deleted'),
            $maxLimit
        );
    }

    /** Не возвращаются со статусом "удален"
     * @return AdmissionPlusClientAndPetAndInvoices[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByPetId(int $petId, int $maxLimit = 100): array
    {
        return $this->getByQueryBuilder(
            (new Builder())
                ->where('patient_id', (string)$petId)
                ->where('status', '!=', 'deleted'),
            $maxLimit
        );
    }
}
