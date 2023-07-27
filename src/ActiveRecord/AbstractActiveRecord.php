<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\AbstractModelDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;

abstract class AbstractActiveRecord
{
    public function __construct(
        protected ActiveRecordFactory $activeRecordFactory,
        protected AbstractModelDTO    $modelDTO
    )
    {
    }

    /** @return class-string<AbstractModelDTO> */
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

    protected static function setNewModelDtoFluently(self $object, AbstractModelDTO $newModelDto): static
    {
        $clone = clone $object;
        $clone->modelDTO = $newModelDto;
        return $clone;
    }

    /**
     * @param class-string<self> $activeRecordClass
     * @return class-string<AbstractModelDTO>
     * @throws VetmanagerApiGatewayInnerException
     */
    public static function getDtoClassFromActiveRecordClass(string $activeRecordClass): string
    {
        if (!is_subclass_of($activeRecordClass, self::class)) {
            throw new VetmanagerApiGatewayInnerException("$activeRecordClass is not a subclass of " . self::class);
        }

        return $activeRecordClass::getDtoClass();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public static function getModelKeyInResponseFromActiveRecordClass(string $activeRecordClass): string
    {
        if (!is_subclass_of($activeRecordClass, self::class)) {
            throw new VetmanagerApiGatewayInnerException("$activeRecordClass is not a subclass of " . self::class);
        }

        return $activeRecordClass::getModelKeyInResponse();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public static function getModelRouteKeyFromActiveRecordClass(string $activeRecordClass): string
    {
        if (!is_subclass_of($activeRecordClass, self::class)) {
            throw new VetmanagerApiGatewayInnerException("$activeRecordClass is not a subclass of " . self::class);
        }

        return $activeRecordClass::getRouteKey();
    }
}
