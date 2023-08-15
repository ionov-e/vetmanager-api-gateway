<?php
declare(strict_types=1);

namespace VetmanagerApiGateway;

use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;

/**
 * @template TActiveRecord of AbstractActiveRecord
 * @template TModelDTO of AbstractDTO
 * @internal
 */
class ActiveRecordFactory
{
    public function __construct(
        public readonly ApiConnection $apiService,
        public readonly DtoFactory    $dtoFactory,
        public readonly DtoNormalizer $dtoNormalizer
    )
    {
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @return TActiveRecord[]
     * @throws VetmanagerApiGatewayException
     */
    public function getFromMultipleModelsAsArray(array $modelsAsArray, string $activeRecordClass): array
    {
        return array_map(
            fn(array $modelAsArray): AbstractActiveRecord => $this->getFromSingleModelAsArray($modelAsArray, $activeRecordClass),
            $modelsAsArray
        );
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @psalm-return TActiveRecord
     * @throws VetmanagerApiGatewayException
     */
    public function getFromSingleModelAsArray(array $modelAsArray, string $activeRecordClass): AbstractActiveRecord
    {
        $dtoClass = $activeRecordClass::getDtoClassFromActiveRecordClass($activeRecordClass);
        return $this->getFromSingleModelAsArrayAndDtoClass($modelAsArray, $activeRecordClass, $dtoClass);
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @param class-string<TModelDTO> $dtoClass
     * @psalm-return TActiveRecord
     * @throws VetmanagerApiGatewayException
     */
    public function getFromSingleModelAsArrayAndDtoClass(
        array $modelAsArray, string $activeRecordClass, string $dtoClass
    ): AbstractActiveRecord
    {
        $dto = $this->dtoFactory->getFromSingleModelAsArray($modelAsArray, $dtoClass);
        return $this->getFromSingleDto($dto, $activeRecordClass);
    }

    /**
     * @param AbstractDTO[] $modelDTOs
     * @param class-string<TActiveRecord> $activeRecordClass
     * @return TActiveRecord[]
     */
    public function getFromMultipleDtos(array $modelDTOs, string $activeRecordClass): array
    {
        return array_map(
            fn(AbstractDTO $modelDTO): AbstractActiveRecord => $this->getFromSingleDto($modelDTO, $activeRecordClass),
            $modelDTOs
        );
    }

    /**
     * @param class-string<TActiveRecord> $activeRecordClass
     * @psalm-return TActiveRecord
     */
    public function getFromSingleDto(AbstractDTO $modelDTO, string $activeRecordClass): AbstractActiveRecord
    {
        return new $activeRecordClass($this, $modelDTO);
    }

    /** Создание чистого нового Active Record для дальнейшей отправки на сервер
     * @param class-string<TActiveRecord> $activeRecordClass
     * @psalm-return TActiveRecord
     * @throws VetmanagerApiGatewayInnerException
     */
    public function getEmpty(string $activeRecordClass): AbstractActiveRecord
    {
        $dtoClass = $activeRecordClass::getDtoClassFromActiveRecordClass($activeRecordClass);
        $emptyDto = $this->dtoFactory->getEmpty($dtoClass);
        return new $activeRecordClass($this, $emptyDto);
    }
}