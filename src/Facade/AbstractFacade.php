<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\Facade;

use Otis22\VetmanagerRestApi\Query\Builder;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\AbstractModelDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/** @template TActiveRecord of AbstractActiveRecord */
abstract class AbstractFacade
{
    public function __construct(protected ActiveRecordFactory $activeRecordFactory)
    {
    }

    /** @return class-string<AbstractActiveRecord> */
    abstract static public function getDefaultActiveRecord(): string;

    /**
     * @return TActiveRecord[]
     * @throws VetmanagerApiGatewayException
     */
    public function fromApiResponseWithMultipleModelsAsArray(array $apiResponseAsArray): array
    {
        return $this->specificARFromApiResponseWithMultipleModelsAsArray($apiResponseAsArray, static::getDefaultActiveRecord());
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @return TActiveRecord[]
     * @throws VetmanagerApiGatewayException
     */
    public function specificARFromApiResponseWithMultipleModelsAsArray(array $apiResponseAsArray, string $activeRecordClass): array
    {
        return $this->activeRecordFactory->getActiveRecordsFromApiResponseWithMultipleModelsAsArray($apiResponseAsArray, $activeRecordClass);
    }

    /** @throws VetmanagerApiGatewayException */
    public function fromApiResponseWithSingleModelAsArray(array $apiResponseAsArray): AbstractActiveRecord
    {
        return $this->specificARFromApiResponseWithSingleModelAsArray($apiResponseAsArray, static::getDefaultActiveRecord());
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @return TActiveRecord
     * @throws VetmanagerApiGatewayException
     */
    public function specificARFromApiResponseWithSingleModelAsArray(array $apiResponseAsArray, string $activeRecordClass): AbstractActiveRecord
    {
        return $this->activeRecordFactory->getActiveRecordFromApiResponseWithSingleModelAsArray($apiResponseAsArray, $activeRecordClass);
    }

    /**
     * @return TActiveRecord[]
     * @throws VetmanagerApiGatewayException
     */
    public function fromMultipleModelsAsArray(array $modelsAsArray): array
    {
        return $this->specificARFromMultipleModelsAsArray($modelsAsArray, static::getDefaultActiveRecord());
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @return TActiveRecord[]
     * @throws VetmanagerApiGatewayException
     */
    public function specificARFromMultipleModelsAsArray(array $modelsAsArray, string $activeRecordClass): array
    {
        return $this->activeRecordFactory->getActiveRecordsFromMultipleModelsAsArray($modelsAsArray, $activeRecordClass);
    }

    /** @throws VetmanagerApiGatewayException */
    public function fromSingleModelAsArray(array $modelAsArray): AbstractActiveRecord
    {
        return $this->specificARFromSingleModelAsArray($modelAsArray, static::getDefaultActiveRecord());
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @return TActiveRecord
     * @throws VetmanagerApiGatewayException
     */
    public function specificARFromSingleModelAsArray(array $modelAsArray, string $activeRecordClass): AbstractActiveRecord
    {
        return $this->activeRecordFactory->getActiveRecordFromSingleModelAsArray($modelAsArray, $activeRecordClass);
    }

    public function fromSingleDto(AbstractModelDTO $modelDto): AbstractActiveRecord
    {
        return $this->specificARFromSingleDto($modelDto, static::getDefaultActiveRecord());
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @return TActiveRecord
     */
    public function specificARFromSingleDto(AbstractModelDTO $modelDto, string $activeRecordClass): AbstractActiveRecord
    {
        $activeRecordClass = $activeRecordClass ?: static::getDefaultActiveRecord();
        return $this->activeRecordFactory->getActiveRecordFromSingleDto($modelDto, $activeRecordClass);
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @return TActiveRecord
     * @throws VetmanagerApiGatewayException
     */
    protected function protectedGetById(string $activeRecordClass, int $id): AbstractActiveRecord
    {
        $modelKeyInResponse = $activeRecordClass::getModelKeyInResponseFromActiveRecordClass($activeRecordClass);
        $modelRouteKey = $activeRecordClass::getModelRouteKeyFromActiveRecordClass($activeRecordClass);
        $modelAsArray = $this->activeRecordFactory->apiService->getModelById($modelKeyInResponse, $modelRouteKey, $id);
        return $this->activeRecordFactory->getActiveRecordFromSingleModelAsArray($modelAsArray, $activeRecordClass);
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @return TActiveRecord[]
     * @throws VetmanagerApiGatewayException
     */
    protected function protectedGetAll(string $activeRecordClass, int $maxLimitOfReturnedModels = 100): array
    {
        $modelsAsArray = $this->activeRecordFactory->apiService->getModelsOrModelWithPagedQuery(
            $activeRecordClass::getModelKeyInResponseFromActiveRecordClass($activeRecordClass),
            $activeRecordClass::getModelRouteKeyFromActiveRecordClass($activeRecordClass),
            (new Builder())->top($maxLimitOfReturnedModels)
        );
        return $this->activeRecordFactory->getActiveRecordsFromMultipleModelsAsArray($modelsAsArray, $activeRecordClass);
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @return TActiveRecord[]
     * @throws VetmanagerApiGatewayException
     */
    protected function protectedGetByQuery(string $activeRecordClass, PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        $modelsAsArrays = $this->activeRecordFactory->apiService->getModelsWithPagedQuery(
            $activeRecordClass::getModelKeyInResponseFromActiveRecordClass($activeRecordClass),
            $activeRecordClass::getModelRouteKeyFromActiveRecordClass($activeRecordClass),
            $pagedQuery,
            $maxLimitOfReturnedModels
        );
        return $this->activeRecordFactory->getActiveRecordsFromMultipleModelsAsArray($modelsAsArrays, $activeRecordClass);
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
        return $this->activeRecordFactory->getActiveRecordsFromMultipleModelsAsArray($modelsAsArrays, $activeRecordClass);
    }
}