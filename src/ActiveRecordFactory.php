<?php

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
    public function __construct(private readonly ApiGateway $apiGateway)
    {
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @param class-string<TModelDTO> $dtoClass
     * @return TActiveRecord
     * @throws VetmanagerApiGatewayException
     */
    public function getById(
        string $modelKeyInResponse,
        string $modelRouteKey,
        string $activeRecordClass,
        string $dtoClass,
        int    $id
    ): AbstractActiveRecord
    {
        $apiResponseAsArray = $this->apiGateway->getWithId($modelKeyInResponse, $modelRouteKey, $id);
        return self::getActiveRecordFromApiResponseWithSingleModelAsArray(
            $apiResponseAsArray, $modelKeyInResponse, $activeRecordClass, $dtoClass
        );
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @param class-string<TModelDTO> $dtoClass
     * @return TActiveRecord
     * @throws VetmanagerApiGatewayException
     */
    public function getActiveRecordFromApiResponseWithSingleModelAsArray(
        array  $apiResponseAsArray,
        string $modelKeyInResponse,
        string $activeRecordClass,
        string $dtoClass
    ): AbstractActiveRecord
    {
        $dto = $this->apiGateway->getDtoFactory()->getAsDtoFromApiResponseWithSingleModelArray(
            $apiResponseAsArray,
            $modelKeyInResponse,
            $dtoClass
        );
        return self::getActiveRecordFromSingleDto($dto, $activeRecordClass);
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @param class-string<TModelDTO> $dtoClass
     * @return TActiveRecord[]
     * @throws VetmanagerApiGatewayException
     */
    public function getActiveRecordFromApiResponseWithMultipleModelsAsArray(
        array  $apiResponseAsArray,
        string $modelKeyInResponse,
        string $activeRecordClass,
        string $dtoClass
    ): array
    {
        $dtos = $this->apiGateway->getDtoFactory()->getAsDtoFromApiResponseWithMultipleModelsArray(
            $apiResponseAsArray,
            $modelKeyInResponse,
            $dtoClass
        );
        return self::getActiveRecordFromSingleDto($dtos, $activeRecordClass);
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @param class-string<TModelDTO> $dtoClass
     * @return TActiveRecord
     * @throws VetmanagerApiGatewayException
     */
    public function getActiveRecordFromSingleModelAsArray(
        array  $modelAsArray,
        string $activeRecordClass,
        string $dtoClass
    ): AbstractActiveRecord
    {
        $dto = $this->apiGateway->getDtoFactory()->getAsDtoFromSingleModelAsArray($modelAsArray, $dtoClass);
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
        return new $activeRecordClass($this->apiGateway, $modelDTO);
    }
}