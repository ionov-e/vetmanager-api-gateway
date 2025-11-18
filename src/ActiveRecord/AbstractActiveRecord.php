<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;

/**
 * @internal
 */
abstract class AbstractActiveRecord
{
    public function __construct(
        protected ActiveRecordFactory $activeRecordFactory,
        protected AbstractDTO $modelDTO
    ) {
    }

    /** @return class-string<AbstractDTO> */
    abstract public static function getDtoClass(): string;

    /** Model key in ApiRequest path. Example: "{{Domain URL}}/rest/api/client" - "client" is a route key  */
    abstract public static function getRouteKey(): string;

    /** Model key in Api Response
     *
     * Example:
     * {
     * "success": true,
     * "message": "Record Retrieved Successfully",
     * "data": {
     *         "totalCount": 0,
     *         "cityType": []
     *         }
     * }
     *
     * "cityType" is the model key in response
     */
    public static function getModelKeyInResponse(): string
    {
        return static::getRouteKey(); // Дефолтное значение. В редких случаях нужно перезаписать
    }

    /**
     * @param class-string<self> $activeRecordClass
     * @return class-string<AbstractDTO>
     * @throws VetmanagerApiGatewayInnerException
     */
    public static function getDtoClassFromActiveRecordClass(string $activeRecordClass): string
    {
        if (!is_subclass_of($activeRecordClass, self::class)) {
            throw new VetmanagerApiGatewayInnerException("$activeRecordClass is not a subclass of " . self::class);
        }

        return $activeRecordClass::getDtoClass();
    }

    /**
     * @param class-string<AbstractActiveRecord> $activeRecordClass
     */
    public static function getModelKeyInResponseFromActiveRecordClass(string $activeRecordClass): string
    {
        return $activeRecordClass::getModelKeyInResponse();
    }

    /**
     * @param class-string<AbstractActiveRecord> $activeRecordClass
     */
    public static function getModelRouteKeyFromActiveRecordClass(string $activeRecordClass): string
    {
        return $activeRecordClass::getRouteKey();
    }

    protected static function setNewModelDtoFluently(self $object, AbstractDTO $newModelDto): static
    {
        $clone = clone $object;
        $clone->modelDTO = $newModelDto;
        return $clone;
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function getAsArray(): array
    {
        return $this->activeRecordFactory->dtoNormalizer->getAsArray($this->modelDTO);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function getAsArrayWithSetPropertiesOnly(): array
    {
        return $this->activeRecordFactory->dtoNormalizer->getAsArrayWithSetPropertiesOnly($this->modelDTO);
    }
}
