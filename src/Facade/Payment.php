<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use Otis22\VetmanagerRestApi\Query\Builder;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\ActiveRecord\Invoice\InvoicePlusClientAndPetAndDoctorAndDocuments;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade\Interface\AllRequestsInterface;

class Payment extends AbstractFacade implements AllRequestsInterface #TODO
{
    /** @return class-string<ActiveRecord\Invoice\InvoiceOnly> */
    static public function getBasicActiveRecord(): string
    {
        return ActiveRecord\Invoice\InvoiceOnly::class;
    }

    /** @inheritDoc */
    public function fromSingleModelAsArray(array $modelAsArray): ActiveRecord\Invoice\AbstractInvoice
    {
        return $this->activeRecordFactory->getFromSingleModelAsArray($modelAsArray, self::getBasicActiveRecord());
    }

    /** @inheritDoc
     * @return ActiveRecord\Invoice\AbstractInvoice[]
     */
    public function fromMultipleModelsAsArrays(array $modelsAsArray): array
    {
        return $this->activeRecordFactory->getFromMultipleModelsAsArray($modelsAsArray, self::getBasicActiveRecord());
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ActiveRecord\Invoice\InvoicePlusClientAndPetAndDoctorAndDocuments
    {
        return $this->protectedGetById(InvoicePlusClientAndPetAndDoctorAndDocuments::class, $id);
    }

    /**
     * @return ActiveRecord\Invoice\InvoicePlusClientAndPetAndDoctor[]
     * @throws VetmanagerApiGatewayException
     */
    public function getAll(int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetAll(ActiveRecord\Invoice\InvoicePlusClientAndPetAndDoctor::class, $maxLimitOfReturnedModels);
    }

    /**
     * @return ActiveRecord\Invoice\InvoicePlusClientAndPetAndDoctor[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByPagedQuery(PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetByPagedQuery(ActiveRecord\Invoice\InvoicePlusClientAndPetAndDoctor::class, $pagedQuery, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\Invoice\InvoicePlusClientAndPetAndDoctor[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByQueryBuilder(Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        return $this->protectedGetByQueryBuilder(ActiveRecord\Invoice\InvoicePlusClientAndPetAndDoctor::class, $builder, $maxLimitOfReturnedModels, $pageNumber);
    }

    /** @throws VetmanagerApiGatewayException */
    public function getByGetParametersAsString(string $getParameters): array
    {
        return $this->protectedGetByGetParametersAsString(ActiveRecord\Invoice\InvoicePlusClientAndPetAndDoctor::class, $getParameters);
    }

    /** @throws VetmanagerApiGatewayException */
    public function getNewEmpty(): ActiveRecord\Invoice\InvoiceOnly
    {
        return $this->protectedGetNewEmpty();
    }

    /** @throws VetmanagerApiGatewayException */
    public function createNewUsingArray(array $modelAsArray): ActiveRecord\Invoice\InvoiceOnly
    {
        return $this->protectedCreateNewUsingArray($modelAsArray);
    }

    /** @throws VetmanagerApiGatewayException */
    public function updateUsingIdAndArray(int $id, array $modelAsArray): ActiveRecord\Invoice\InvoiceOnly
    {
        return $this->protectedUpdateUsingIdAndArray($id, $modelAsArray);
    }
}