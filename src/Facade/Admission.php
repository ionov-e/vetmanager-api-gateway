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
     * @return \VetmanagerApiGateway\ActiveRecord\Admission\AdmissionPartial[]
     * @throws VetmanagerApiGatewayException
     */
    public function getAll(int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetAll(ActiveRecord\Admission\AdmissionPartial::class, $maxLimitOfReturnedModels);
    }

    /**
     * @return \VetmanagerApiGateway\ActiveRecord\Admission\AdmissionPartial[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByPagedQuery(PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetByPagedQuery(ActiveRecord\Admission\AdmissionPartial::class, $pagedQuery, $maxLimitOfReturnedModels);
    }

    /** @return \VetmanagerApiGateway\ActiveRecord\Admission\AdmissionPartial[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByQueryBuilder(Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        return $this->protectedGetByQueryBuilder(ActiveRecord\Admission\AdmissionPartial::class, $builder, $maxLimitOfReturnedModels, $pageNumber);
    }

    /** @inheritDoc
     * @throws VetmanagerApiGatewayException
     */
    public function getByParametersAsString(string $getParameters): array
    {
        return $this->protectedGetByGetParametersAsString(ActiveRecord\Admission\AdmissionPartial::class, $getParameters);
    }

    /** @inheritDoc
     * @throws VetmanagerApiGatewayInnerException
     */
    public function getNewEmpty(): ActiveRecord\Admission\AdmissionPartial
    {
        return $this->activeRecordFactory->getEmpty(ActiveRecord\Admission\AdmissionPartial::class);
    }

    /** @inheritDoc
     * @throws VetmanagerApiGatewayException
     */
    public function createNewUsingArray(array $modelAsArray): ActiveRecord\Admission\AdmissionPartial
    {
        return $this->protectedCreateNewUsingArray(ActiveRecord\Admission\AdmissionPartial::class, $modelAsArray);
    }

    /** @inheritDoc
     * @throws VetmanagerApiGatewayException
     */
    public function updateUsingIdAndArray(int $id, array $modelAsArray): ActiveRecord\Admission\AdmissionPartial
    {
        return $this->protectedUpdateUsingIdAndArray(ActiveRecord\Admission\AdmissionPartial::class, $id, $modelAsArray);
    }


    /** Не возвращаются со статусом "удален"
     * @return \VetmanagerApiGateway\ActiveRecord\Admission\AdmissionPartial[]
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
     * @return \VetmanagerApiGateway\ActiveRecord\Admission\AdmissionPartial[]
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