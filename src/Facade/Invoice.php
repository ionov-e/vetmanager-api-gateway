<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use Otis22\VetmanagerRestApi\Query\Builder;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade\Interface\AllRequestsInterface;

class Invoice extends AbstractFacade implements AllRequestsInterface
{
    static public function getBasicActiveRecord(): string
    {
        return ActiveRecord\Invoice\InvoiceOnly::class;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ActiveRecord\Invoice\InvoicePlusClientAndPetAndDoctorAndDocuments
    {
        return $this->protectedGetById(self::getBasicActiveRecord(), $id);
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
    public function getByParametersAsString(string $getParameters): array
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