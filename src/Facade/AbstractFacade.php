<?php

namespace VetmanagerApiGateway\Facade;

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
    protected function protectedGetById(int $id, string $activeRecordClass): AbstractActiveRecord
    {
        return $this->activeRecordFactory->getById($activeRecordClass, $id);
    }
}