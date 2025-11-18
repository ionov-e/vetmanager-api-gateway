<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;

/**
 * @internal
 */
abstract class AbstractDTO
{
    /** @var string[] list of properties provided by client from setters */
    protected array $propertiesSet = [];

    /** Returns list of properties set by client (this library user) */
    public function getPropertiesSet(): array
    {
        return $this->propertiesSet;
    }

    /** @throws VetmanagerApiGatewayInnerException */
    protected static function setPropertyFluently(self $object, string $propertyName, null|int|string $value): static
    {
        $clone = clone $object;

        if (!property_exists($clone, $propertyName)) {
            throw new VetmanagerApiGatewayInnerException("There's no property '$propertyName' in " . $clone::class);
        }

        $clone->$propertyName = $value;
        $clone->propertiesSet[] = $propertyName;
        return $clone;
    }
}
