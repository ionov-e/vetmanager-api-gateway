<?php

namespace VetmanagerApiGateway;

use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\DTO\AbstractModelDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;

/**
 * @template TActiveRecord of AbstractActiveRecord
 * @template TModelDTO of AbstractModelDTO
 */
class ActiveRecordFactory
{
    public function __construct(
        public readonly ApiService $apiService,
        public readonly DtoFactory $dtoFactory
    )
    {
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @return TActiveRecord
     * @throws VetmanagerApiGatewayException
     */
    public function getById(string $activeRecordClass, int $id): AbstractActiveRecord
    {
        $modelKeyInResponse = $this->getModelKeyInResponseFromActiveRecordClass($activeRecordClass);
        $modelRouteKey = $this->getModelRouteKeyFromActiveRecordClass($activeRecordClass);
        $modelAsArray = $this->apiService->getWithId($modelKeyInResponse, $modelRouteKey, $id);
        return self::getActiveRecordFromSingleModelAsArray($modelAsArray, $activeRecordClass);
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @return TActiveRecord
     * @throws VetmanagerApiGatewayException
     */
    public function getActiveRecordFromApiResponseWithSingleModelAsArray(array $apiResponseAsArray, string $activeRecordClass): AbstractActiveRecord
    {
        $modelKeyInResponse = $this->getModelKeyInResponseFromActiveRecordClass($activeRecordClass);
        $dtoClass = $this->getDtoClassFromActiveRecordClass($activeRecordClass);
        $dto = $this->dtoFactory->getAsDtoFromApiResponseWithSingleModelArray(
            $apiResponseAsArray,
            $modelKeyInResponse,
            $dtoClass
        );
        return self::getActiveRecordFromSingleDto($dto, $activeRecordClass);
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @return TActiveRecord[]
     * @throws VetmanagerApiGatewayException
     */
    public function getActiveRecordFromApiResponseWithMultipleModelsAsArray(
        array  $apiResponseAsArray,
        string $modelKeyInResponse,
        string $activeRecordClass
    ): array
    {
        $dtoClass = $this->getDtoClassFromActiveRecordClass($activeRecordClass);
        $dtos = $this->dtoFactory->getAsDtosFromApiResponseWithMultipleModelsArray(
            $apiResponseAsArray,
            $modelKeyInResponse,
            $dtoClass
        );
        return self::getActiveRecordsFromMultipleDtos($dtos, $activeRecordClass);
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @return TActiveRecord
     * @throws VetmanagerApiGatewayException
     */
    public function getActiveRecordFromSingleModelAsArray(array $modelAsArray, string $activeRecordClass): AbstractActiveRecord
    {
        $dtoClass = $this->getDtoClassFromActiveRecordClass($activeRecordClass);
        $dto = $this->dtoFactory->getAsDtoFromSingleModelAsArray($modelAsArray, $dtoClass);
        return $this->getActiveRecordFromSingleDto($dto, $activeRecordClass);
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @throws VetmanagerApiGatewayInnerException
     */
    private function getDtoClassFromActiveRecordClass(string $activeRecordClass): string
    {
        if (!is_subclass_of($activeRecordClass, AbstractActiveRecord::class)) {
            throw new VetmanagerApiGatewayInnerException("$activeRecordClass is not a subclass of " . AbstractActiveRecord::class);
        }

        return $activeRecordClass::getDtoClass();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    private function getModelKeyInResponseFromActiveRecordClass(string $activeRecordClass): string
    {
        if (!is_subclass_of($activeRecordClass, AbstractActiveRecord::class)) {
            throw new VetmanagerApiGatewayInnerException("$activeRecordClass is not a subclass of " . AbstractActiveRecord::class);
        }

        return $activeRecordClass::getModelKeyInResponse();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    private function getModelRouteKeyFromActiveRecordClass(string $activeRecordClass): string
    {
        if (!is_subclass_of($activeRecordClass, AbstractActiveRecord::class)) {
            throw new VetmanagerApiGatewayInnerException("$activeRecordClass is not a subclass of " . AbstractActiveRecord::class);
        }

        return $activeRecordClass::getRouteKey();
    }

    /**
     * @param AbstractModelDTO[] $modelDTOs
     * @param class-string<TActiveRecord> $activeRecordClass
     * @return TActiveRecord[]
     */
    public function getActiveRecordsFromMultipleDtos(array $modelDTOs, string $activeRecordClass): array
    {
        return array_map(
            fn(AbstractModelDTO $modelDTO): AbstractActiveRecord => $this->getActiveRecordFromSingleDto($modelDTO, $activeRecordClass),
            $modelDTOs
        );
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @return TActiveRecord
     */
    public function getActiveRecordFromSingleDto(AbstractModelDTO $modelDTO, string $activeRecordClass): AbstractActiveRecord
    {
        return new $activeRecordClass($this, $modelDTO);
    }
}