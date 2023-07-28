<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use Otis22\VetmanagerRestApi\Query\Builder;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Facade\Interface\AllRequestsInterface;

class Admission extends AbstractFacade implements AllRequestsInterface
{
    static public function getDefaultActiveRecord(): string
    {
        return ActiveRecord\Admission::class;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ActiveRecord\AdmissionFull
    {
        return $this->protectedGetById(self::getDefaultActiveRecord(), $id);
    }

    /**
     * @return ActiveRecord\AdmissionPartial[]
     * @throws VetmanagerApiGatewayException
     */
    public function getAll(int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetAll(ActiveRecord\AdmissionPartial::class, $maxLimitOfReturnedModels);
    }

    /**
     * @return ActiveRecord\AdmissionPartial[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByPagedQuery(PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetByPagedQuery(ActiveRecord\AdmissionPartial::class, $pagedQuery, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\AdmissionPartial[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByQueryBuilder(Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        return $this->protectedGetByQueryBuilder(ActiveRecord\AdmissionPartial::class, $builder, $maxLimitOfReturnedModels, $pageNumber);
    }

    /** @inheritDoc
     * @throws VetmanagerApiGatewayException
     */
    public function getByParametersAsString(string $getParameters): array
    {
        return $this->protectedGetByGetParametersAsString(ActiveRecord\AdmissionPartial::class, $getParameters);
    }

    /** @inheritDoc
     * @throws VetmanagerApiGatewayInnerException
     */
    public function getNewEmpty(): ActiveRecord\AdmissionPartial
    {
        return $this->activeRecordFactory->getEmpty(ActiveRecord\AdmissionPartial::class);
    }

    /** @inheritDoc
     * @throws VetmanagerApiGatewayException
     */
    public function createNewUsingArray(array $modelAsArray): ActiveRecord\AdmissionPartial
    {
        return $this->protectedCreateNewUsingArray(ActiveRecord\AdmissionPartial::class, $modelAsArray);
    }

    /** @inheritDoc
     * @throws VetmanagerApiGatewayException
     */
    public function updateUsingIdAndArray(int $id, array $modelAsArray): ActiveRecord\AdmissionPartial
    {
        return $this->protectedUpdateUsingIdAndArray(ActiveRecord\AdmissionPartial::class, $id, $modelAsArray);
    }


    /** Не возвращаются со статусом "удален"
     * @return ActiveRecord\AdmissionPartial[]
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
     * @return ActiveRecord\AdmissionPartial[]
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