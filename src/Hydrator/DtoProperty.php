<?php

namespace VetmanagerApiGateway\Hydrator;

use DateTime;
use VetmanagerApiGateway\Hydrator\Enum\DtoPropertyMode;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;

class DtoProperty
{
    public function __construct(
        private readonly AbstractDTO              $dto,
        private readonly string                   $propertyKey,
        private readonly DtoPropertyMode $mode = DtoPropertyMode::Default
    ) {
    }

    /** @throws VetmanagerApiGatewayRequestException */
    public function toArrayAsKeyAndConvertedValue(string $arrayKey): array
    {
        return [$arrayKey => $this->getConvertedValue()];
    }

    /** @throws VetmanagerApiGatewayRequestException */
    public function getConvertedValue(): null|int|float|string|array
    {
        return match ($this->mode) {
            DtoPropertyMode::Default => $this->getPropertyValueUsingDefaultConverting()
        };
    }

    /** @throws VetmanagerApiGatewayRequestException */
    private function getPropertyValueUsingDefaultConverting(): null|int|float|string|array
    {
        $propertyKey = $this->propertyKey;
        $propertyValue = $this->dto->$propertyKey;

        if ($propertyValue instanceof DateTime) {
            return $propertyValue->format('Y-m-d H:i:s');
        }

        if (is_bool($propertyValue)) {
            return (int)$propertyValue;
        }

        if (is_null($propertyValue) || is_integer($propertyValue) || is_float($propertyValue) || is_string($propertyValue) || is_array($propertyValue)) {
            return $propertyValue;
        }

        throw new VetmanagerApiGatewayRequestException(
            $this->dto::class . "->$propertyKey: не получилось получить значение подходящее для Post или Put запроса: " . json_encode($propertyValue)
        );
    }
}
