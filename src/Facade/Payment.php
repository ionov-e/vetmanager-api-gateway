<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use Otis22\VetmanagerRestApi\Query\Builder;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade\Interface\AllRequestsInterface;

class Payment extends AbstractFacade implements AllRequestsInterface
{
    /** @return class-string<ActiveRecord\Payment\PaymentOnly> */
    public static function getBasicActiveRecord(): string
    {
        return ActiveRecord\Payment\PaymentOnly::class;
    }

    /** @inheritDoc */
    public function fromSingleModelAsArray(array $modelAsArray): ActiveRecord\Payment\AbstractPayment
    {
        return $this->activeRecordFactory->getFromSingleModelAsArray($modelAsArray, self::getBasicActiveRecord());
    }

    /** @inheritDoc
     * @return ActiveRecord\Payment\AbstractPayment[]
     */
    public function fromMultipleModelsAsArrays(array $modelsAsArray): array
    {
        return $this->activeRecordFactory->getFromMultipleModelsAsArray($modelsAsArray, self::getBasicActiveRecord());
    }

    /** @throws VetmanagerApiGatewayException */
    public function getById(int $id): ?ActiveRecord\Payment\PaymentPlusCassaAndCassaClose
    {
        return $this->protectedGetById(ActiveRecord\Payment\PaymentPlusCassaAndCassaClose::class, $id);
    }

    /**
     * @return ActiveRecord\Payment\PaymentPlusCassaAndCassaClose[]
     * @throws VetmanagerApiGatewayException
     */
    public function getAll(int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetAll(ActiveRecord\Payment\PaymentPlusCassaAndCassaClose::class, $maxLimitOfReturnedModels);
    }

    /**
     * @return ActiveRecord\Payment\PaymentPlusCassaAndCassaClose[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByPagedQuery(PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        return $this->protectedGetByPagedQuery(ActiveRecord\Payment\PaymentPlusCassaAndCassaClose::class, $pagedQuery, $maxLimitOfReturnedModels);
    }

    /** @return ActiveRecord\Payment\PaymentPlusCassaAndCassaClose[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByQueryBuilder(Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        return $this->protectedGetByQueryBuilder(ActiveRecord\Payment\PaymentPlusCassaAndCassaClose::class, $builder, $maxLimitOfReturnedModels, $pageNumber);
    }

    /** @throws VetmanagerApiGatewayException */
    public function getByGetParametersAsString(string $getParameters): array
    {
        return $this->protectedGetByGetParametersAsString(ActiveRecord\Payment\PaymentPlusCassaAndCassaClose::class, $getParameters);
    }

    /** @throws VetmanagerApiGatewayException */
    public function getNewEmpty(): ActiveRecord\Payment\PaymentOnly
    {
        return $this->protectedGetNewEmpty();
    }

    /** @throws VetmanagerApiGatewayException */
    public function createNewUsingArray(array $modelAsArray): ActiveRecord\Payment\PaymentOnly
    {
        return $this->protectedCreateNewUsingArray($modelAsArray);
    }

    /** @throws VetmanagerApiGatewayException */
    public function updateUsingIdAndArray(int $id, array $modelAsArray): ActiveRecord\Payment\PaymentOnly
    {
        return $this->protectedUpdateUsingIdAndArray($id, $modelAsArray);
    }

    /**
     * @return ActiveRecord\Payment\AbstractPayment[]
     * @throws VetmanagerApiGatewayException
     */
    public function getByInvoiceId(int $invoiceId, string $additionalGetParameters = ''): array
    {
        $additionalGetParametersWithAmpersandOrNothing = $additionalGetParameters ? "&{$additionalGetParameters}" : '';
        return $this->getByGetParametersAsString("invoice_id={$invoiceId}{$additionalGetParametersWithAmpersandOrNothing}");
    }
}
