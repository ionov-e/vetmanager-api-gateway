<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use Otis22\VetmanagerRestApi\Query\Builder;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade\Interface\AllRequestsInterface;

class InvoiceDocument extends AbstractFacade implements AllRequestsInterface
{
    /** @return class-string<ActiveRecord\InvoiceDocument\InvoiceDocumentOnly> */
    static public function getBasicActiveRecord(): string
    {
        return ActiveRecord\InvoiceDocument\InvoiceDocumentOnly::class;
    }

    /** @inheritDoc */
    public function fromSingleModelAsArray(array $modelAsArray): ActiveRecord\InvoiceDocument\AbstractInvoiceDocument
    {
        return $this->activeRecordFactory->getFromSingleModelAsArray($modelAsArray, self::getBasicActiveRecord());
    }

    /** @inheritDoc
     * @return ActiveRecord\InvoiceDocument\AbstractInvoiceDocument[]
     */
    public function fromMultipleModelsAsArrays(array $modelsAsArray): array
    {
        return $this->activeRecordFactory->getFromMultipleModelsAsArray($modelsAsArray, self::getBasicActiveRecord());
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ?ActiveRecord\InvoiceDocument\InvoiceDocumentPlusGoodSaleParamAndUnitAndInvoiceAndGoodWithPartyInfoAndMinMax
    {
        return $this->protectedGetById(ActiveRecord\InvoiceDocument\InvoiceDocumentPlusGoodSaleParamAndUnitAndInvoiceAndGoodWithPartyInfoAndMinMax::class, $id);
    }

    /**
     * @return ActiveRecord\InvoiceDocument\InvoiceDocumentPlusGoodSaleParamAndUnitAndInvoiceAndGood[]
     * @throws VetmanagerApiGatewayException
     */
    public function getAll(int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetAll(ActiveRecord\InvoiceDocument\InvoiceDocumentPlusGoodSaleParamAndUnitAndInvoiceAndGood::class, $maxLimitOfReturnedModels);
    }

    /**
     * @return ActiveRecord\InvoiceDocument\InvoiceDocumentPlusGoodSaleParamAndUnitAndInvoiceAndGood[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByPagedQuery(PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetByPagedQuery(ActiveRecord\InvoiceDocument\InvoiceDocumentPlusGoodSaleParamAndUnitAndInvoiceAndGood::class, $pagedQuery, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\InvoiceDocument\InvoiceDocumentPlusGoodSaleParamAndUnitAndInvoiceAndGood[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByQueryBuilder(Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        return $this->protectedGetByQueryBuilder(ActiveRecord\InvoiceDocument\InvoiceDocumentPlusGoodSaleParamAndUnitAndInvoiceAndGood::class, $builder, $maxLimitOfReturnedModels, $pageNumber);
    }

    /** @throws VetmanagerApiGatewayException */
    public function getByGetParametersAsString(string $getParameters): array
    {
        return $this->protectedGetByGetParametersAsString(ActiveRecord\InvoiceDocument\InvoiceDocumentPlusGoodSaleParamAndUnitAndInvoiceAndGood::class, $getParameters);
    }

    /** @throws VetmanagerApiGatewayException */
    public function getNewEmpty(): ActiveRecord\InvoiceDocument\InvoiceDocumentOnly
    {
        return $this->protectedGetNewEmpty();
    }

    /** @throws VetmanagerApiGatewayException */
    public function createNewUsingArray(array $modelAsArray): ActiveRecord\InvoiceDocument\InvoiceDocumentOnly
    {
        return $this->protectedCreateNewUsingArray($modelAsArray);
    }

    /** @throws VetmanagerApiGatewayException */
    public function updateUsingIdAndArray(int $id, array $modelAsArray): ActiveRecord\InvoiceDocument\InvoiceDocumentOnly
    {
        return $this->protectedUpdateUsingIdAndArray($id, $modelAsArray);
    }
}