<?php
declare(strict_types=1);

namespace VetmanagerApiGateway;

use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\DTO\AbstractModelDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

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
    public function getActiveRecordFromApiResponseWithSingleModelAsArray(array $apiResponseAsArray, string $activeRecordClass): AbstractActiveRecord
    {
        $modelKeyInResponse = $activeRecordClass::getModelKeyInResponseFromActiveRecordClass($activeRecordClass);
        $dtoClass = $activeRecordClass::getDtoClassFromActiveRecordClass($activeRecordClass);
        $dto = $this->dtoFactory->getAsDtoFromApiResponseWithSingleModelAsArray(
            $apiResponseAsArray,
            $modelKeyInResponse,
            $dtoClass
        );
        return $this->getActiveRecordFromSingleDto($dto, $activeRecordClass);
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @return TActiveRecord[]
     * @throws VetmanagerApiGatewayException
     */
    public function getActiveRecordsFromApiResponseWithMultipleModelsAsArray(array $apiResponseAsArray, string $activeRecordClass): array
    {
        $modelKeyInResponse = $activeRecordClass::getModelKeyInResponseFromActiveRecordClass($activeRecordClass);
        $dtoClass = $activeRecordClass::getDtoClassFromActiveRecordClass($activeRecordClass);
        $dtos = $this->dtoFactory->getAsDtosFromApiResponseWithMultipleModelsArray(
            $apiResponseAsArray,
            $modelKeyInResponse,
            $dtoClass
        );
        return $this->getActiveRecordsFromMultipleDtos($dtos, $activeRecordClass);
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @return TActiveRecord[]
     * @throws VetmanagerApiGatewayException
     */
    public function getActiveRecordsFromMultipleModelsAsArray(array $modelsAsArray, string $activeRecordClass): array
    {
        return array_map(
            fn(array $modelAsArray): AbstractActiveRecord => $this->getActiveRecordFromSingleModelAsArray($modelAsArray, $activeRecordClass),
            $modelsAsArray
        );
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @return TActiveRecord
     * @throws VetmanagerApiGatewayException
     */
    public function getActiveRecordFromSingleModelAsArray(array $modelAsArray, string $activeRecordClass): AbstractActiveRecord
    {
        $dtoClass = $activeRecordClass::getDtoClassFromActiveRecordClass($activeRecordClass);
        return $this->getActiveRecordFromSingleModelAsArrayAndDtoClass($modelAsArray, $activeRecordClass, $dtoClass);
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @param class-string<TModelDTO> $dtoClass
     * @return TActiveRecord
     * @throws VetmanagerApiGatewayException
     */
    public function getActiveRecordFromSingleModelAsArrayAndDtoClass(
        array $modelAsArray, string $activeRecordClass, string $dtoClass
    ): AbstractActiveRecord
    {
        $dto = $this->dtoFactory->getAsDtoFromSingleModelAsArray($modelAsArray, $dtoClass);
        return $this->getActiveRecordFromSingleDto($dto, $activeRecordClass);
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