<?php

namespace VetmanagerApiGateway\Facade;

use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO\AbstractModelDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/**
 * @template TActiveRecord of AbstractActiveRecord
 * @template TModelDTO of AbstractModelDTO
 */
abstract class AbstractFacade
{
    public function __construct(protected ApiGateway $apiGateway)
    {
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @param class-string<TModelDTO> $dtoRecordClass
     * @return TActiveRecord
     * @throws VetmanagerApiGatewayException
     */
    protected static function protectedGetById(ApiGateway $apiGateway, ApiModel $apiModel, string $activeRecordClass, string $dtoRecordClass, int $id)
    {
        $apiResponseAsArray = $apiGateway->getWithId($apiModel, $id);
        return self::getActiveRecordFromApiResponseAsArray($apiGateway, $apiResponseAsArray, $apiModel, $activeRecordClass, $dtoRecordClass);
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @param class-string<TModelDTO> $dtoClass
     * @return TActiveRecord
     * @throws VetmanagerApiGatewayException
     */
    public static function getActiveRecordFromApiResponseAsArray(
        ApiGateway $apiGateway,
        array      $apiResponseAsArray,
        ApiModel   $apiModel,
        string     $activeRecordClass,
        string     $dtoClass
    ): AbstractActiveRecord
    {
        $dto = $apiGateway->getDtoFactory()->getAsDtoFromApiResponseAsArray(
            $apiResponseAsArray,
            $apiModel->getResponseKey(),
            $dtoClass
        );
        return self::getActiveRecordFromDto($apiGateway, $dto, $activeRecordClass);
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @param class-string<TModelDTO> $dtoClass
     * @return TActiveRecord
     * @throws VetmanagerApiGatewayException
     */
    public static function getActiveRecordFromModelAsArray(
        ApiGateway $apiGateway,
        array      $modelAsArray,
        string     $activeRecordClass,
        string     $dtoClass
    ): AbstractActiveRecord
    {
        $dto = $apiGateway->getDtoFactory()->getAsDtoFromSingleModelAsArray($modelAsArray, $dtoClass);
        return self::getActiveRecordFromDto($apiGateway, $dto, $activeRecordClass);
    }

    public static function getActiveRecordFromDto(
        ApiGateway       $apiGateway,
        AbstractModelDTO $modelAsArray,
        string           $activeRecordClass
    ): AbstractActiveRecord
    {
        return new $activeRecordClass($apiGateway, $modelAsArray);
    }
}