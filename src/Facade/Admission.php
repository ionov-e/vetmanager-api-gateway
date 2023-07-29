<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use Otis22\VetmanagerRestApi\Query\Builder;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\ActiveRecord\Admission\AdmissionPartial;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Facade\Interface\AllRequestsInterface;

class Admission extends AbstractFacade implements AllRequestsInterface
{
    static public function getBasicActiveRecord(): string
    {
        return ActiveRecord\Admission\AdmissionOnly::class;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ActiveRecord\Admission\AdmissionFull
    {
        return $this->protectedGetById(self::getBasicActiveRecord(), $id);
    }

    /**
     * @return AdmissionPartial[]
     * @throws VetmanagerApiGatewayException
     */
    public function getAll(int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetAll(AdmissionPartial::class, $maxLimitOfReturnedModels);
    }

    /**
     * @return AdmissionPartial[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByPagedQuery(PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetByPagedQuery(AdmissionPartial::class, $pagedQuery, $maxLimitOfReturnedModels);
    }

    /** @return AdmissionPartial[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByQueryBuilder(Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        return $this->protectedGetByQueryBuilder(AdmissionPartial::class, $builder, $maxLimitOfReturnedModels, $pageNumber);
    }

    /**
     * @throws VetmanagerApiGatewayException
     */
    public function getByParametersAsString(string $getParameters): array
    {
        return $this->protectedGetByGetParametersAsString(AdmissionPartial::class, $getParameters);
    }

    /**
     * @throws VetmanagerApiGatewayInnerException
     */
    public function getNewEmpty(): AdmissionPartial
    {
        return $this->activeRecordFactory->getEmpty(AdmissionPartial::class);
    }

    /** @throws VetmanagerApiGatewayException */
    public function createNewUsingArray(array $modelAsArray): AdmissionPartial
    {
        return $this->protectedCreateNewUsingArray(AdmissionPartial::class, $modelAsArray);
    }

    /** @throws VetmanagerApiGatewayException */
    public function updateUsingIdAndArray(int $id, array $modelAsArray): AdmissionPartial
    {
        return $this->protectedUpdateUsingIdAndArray(AdmissionPartial::class, $id, $modelAsArray);
    }


    /** Не возвращаются со статусом "удален"
     * @return AdmissionPartial[]
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
     * @return AdmissionPartial[]
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