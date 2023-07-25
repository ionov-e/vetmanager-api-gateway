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
        return self::getActiveRecordFromApiResponseAsArray(
            $apiResponseAsArray, $modelKeyInResponse, $activeRecordClass, $dtoClass
        );
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @param class-string<TModelDTO> $dtoClass
     * @return TActiveRecord
     * @throws VetmanagerApiGatewayException
     */
    public function getActiveRecordFromApiResponseAsArray(
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
        return self::getActiveRecordFromDto($dto, $activeRecordClass);
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @param class-string<TModelDTO> $dtoClass
     * @return TActiveRecord
     * @throws VetmanagerApiGatewayException
     */
    public function getActiveRecordFromModelAsArray(
        array  $modelAsArray,
        string $activeRecordClass,
        string $dtoClass
    ): AbstractActiveRecord
    {
        $dto = $this->apiGateway->getDtoFactory()->getAsDtoFromSingleModelAsArray($modelAsArray, $dtoClass);
        return $this->getActiveRecordFromDto($dto, $activeRecordClass);
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @return TActiveRecord
     */
    public function getActiveRecordFromDto(AbstractModelDTO $modelDTO, string $activeRecordClass): AbstractActiveRecord
    {
        return new $activeRecordClass($this->apiGateway, $modelDTO);
    }
}