<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use Otis22\VetmanagerRestApi\Query\Builder;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

/**
 * @template TActiveRecord of AbstractActiveRecord
 * @internal
 */
abstract class AbstractFacade
{
    public function __construct(protected ActiveRecordFactory $activeRecordFactory)
    {
    }

    /** Дефолтный Active Record с самым минимальным DTO (без вложенных DTO)
     * @return class-string<AbstractActiveRecord>
     */
    abstract static public function getBasicActiveRecord(): string;

    /** @throws VetmanagerApiGatewayException */
    abstract public function fromSingleModelAsArray(array $modelAsArray): AbstractActiveRecord;

    /**
     * @return AbstractActiveRecord[]
     * @throws VetmanagerApiGatewayException
     */
    abstract public function fromMultipleModelsAsArrays(array $modelsAsArray): array;

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @psalm-return TActiveRecord
     * @throws VetmanagerApiGatewayException
     */
    protected function protectedGetById(string $activeRecordClass, int $id): AbstractActiveRecord
    {
        $modelKeyInResponse = $activeRecordClass::getModelKeyInResponseFromActiveRecordClass($activeRecordClass);
        $modelRouteKey = $activeRecordClass::getModelRouteKeyFromActiveRecordClass($activeRecordClass);
        $modelAsArray = $this->activeRecordFactory->apiService->getModelById($modelKeyInResponse, $modelRouteKey, $id);
        return $this->activeRecordFactory->getFromSingleModelAsArray($modelAsArray, $activeRecordClass);
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @return TActiveRecord[]
     * @throws VetmanagerApiGatewayException
     */
    protected function protectedGetAll(string $activeRecordClass, int $maxLimitOfReturnedModels = 100): array
    {
        $modelsAsArray = $this->activeRecordFactory->apiService->getModelsWithPagedQuery(
            $activeRecordClass::getModelKeyInResponseFromActiveRecordClass($activeRecordClass),
            $activeRecordClass::getModelRouteKeyFromActiveRecordClass($activeRecordClass),
            (new Builder())->top($maxLimitOfReturnedModels)
        );
        return $this->activeRecordFactory->getFromMultipleModelsAsArray($modelsAsArray, $activeRecordClass);
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @return TActiveRecord[]
     * @throws VetmanagerApiGatewayException
     */
    protected function protectedGetByPagedQuery(string $activeRecordClass, PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        $modelsAsArrays = $this->activeRecordFactory->apiService->getModelsWithPagedQuery(
            $activeRecordClass::getModelKeyInResponseFromActiveRecordClass($activeRecordClass),
            $activeRecordClass::getModelRouteKeyFromActiveRecordClass($activeRecordClass),
            $pagedQuery,
            $maxLimitOfReturnedModels
        );
        return $this->activeRecordFactory->getFromMultipleModelsAsArray($modelsAsArrays, $activeRecordClass);
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @return TActiveRecord[]
     * @throws VetmanagerApiGatewayException
     */
    protected function protectedGetByQueryBuilder(string $activeRecordClass, Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        $modelsAsArrays = $this->activeRecordFactory->apiService->getModelsWithQueryBuilder(
            $activeRecordClass::getModelKeyInResponseFromActiveRecordClass($activeRecordClass),
            $activeRecordClass::getModelRouteKeyFromActiveRecordClass($activeRecordClass),
            $builder,
            $maxLimitOfReturnedModels,
            $pageNumber
        );
        return $this->activeRecordFactory->getFromMultipleModelsAsArray($modelsAsArrays, $activeRecordClass);
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @return TActiveRecord[]
     * @throws VetmanagerApiGatewayException
     */
    protected function protectedGetByGetParametersAsString(string $activeRecordClass, string $getParameters): array
    {
        $modelsAsArrays = $this->activeRecordFactory->apiService->getModelsWithGetParametersAsString(
            $activeRecordClass::getModelKeyInResponseFromActiveRecordClass($activeRecordClass),
            $activeRecordClass::getModelRouteKeyFromActiveRecordClass($activeRecordClass),
            $getParameters
        );
        return $this->activeRecordFactory->getFromMultipleModelsAsArray($modelsAsArrays, $activeRecordClass);
    }

    /**
     * @psalm-return TActiveRecord
     * @throws VetmanagerApiGatewayException
     */
    public function protectedGetNewEmpty(): AbstractActiveRecord
    {
        return $this->activeRecordFactory->getEmpty(static::getBasicActiveRecord());
    }

    /**
     * Отправка на сервер модели и возвращение от сервера модели в виде Active Record
     *
     * @psalm-return TActiveRecord
     * @throws VetmanagerApiGatewayException
     */
    protected function protectedCreateNewUsingArray(array $modelAsArray): AbstractActiveRecord
    {
        /** @var class-string<AbstractActiveRecord> $activeRecordClass */
        $activeRecordClass = static::getBasicActiveRecord();
        // Возвращается почему-то массив с одним элементом - нашей созданной моделью
        $createdModelsAsArray = $this->activeRecordFactory->apiService->post(
            $activeRecordClass::getModelRouteKeyFromActiveRecordClass($activeRecordClass),
            $activeRecordClass::getModelKeyInResponseFromActiveRecordClass($activeRecordClass),
            $modelAsArray
        );
        $createdModelAsArray = $createdModelsAsArray[0];
        return $this->activeRecordFactory->getFromSingleModelAsArray($createdModelAsArray, $activeRecordClass);
    }

    /**
     * Отправка на сервер модели и возвращение от сервера модели в виде Active Record
     *
     * @psalm-return TActiveRecord
     * @throws VetmanagerApiGatewayException
     */
    protected function protectedUpdateUsingIdAndArray(int $id, array $modelAsArray): AbstractActiveRecord
    {
        /** @var class-string<AbstractActiveRecord> $activeRecordClass */
        $activeRecordClass = static::getBasicActiveRecord();
        $createdModelAsArray = $this->activeRecordFactory->apiService->put(
            $activeRecordClass::getModelRouteKeyFromActiveRecordClass($activeRecordClass),
            $activeRecordClass::getModelKeyInResponseFromActiveRecordClass($activeRecordClass),
            $id,
            $modelAsArray
        );
        return $this->activeRecordFactory->getFromSingleModelAsArray($createdModelAsArray, $activeRecordClass);
    }

    /**
     * @throws VetmanagerApiGatewayRequestException
     * @throws VetmanagerApiGatewayResponseException
     */
    public function delete(int $id): void
    {
        /** @var class-string<AbstractActiveRecord> $activeRecordClass */
        $activeRecordClass = static::getBasicActiveRecord();
        $this->activeRecordFactory->apiService->delete(
            $activeRecordClass::getModelRouteKeyFromActiveRecordClass($activeRecordClass),
            $id
        );
    }
}