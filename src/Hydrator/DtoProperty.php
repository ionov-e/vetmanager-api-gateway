<?php

namespace VetmanagerApiGateway\Hydrator;

use BackedEnum;
use DateTime;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Hydrator\Enum\DtoPropertyMode;

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
            DtoPropertyMode::Default => $this->getPropertyValueUsingDefaultConverting(),
            DtoPropertyMode::DateTimeOnlyDate => $this->getOnlyDateFromDateTime()
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

        if ($propertyValue instanceof BackedEnum) {
            return $propertyValue->value;
        }

        if (is_null($propertyValue) || is_integer($propertyValue) || is_float($propertyValue) || is_string($propertyValue) || is_array($propertyValue)) {
            return $propertyValue;
        }

        throw new VetmanagerApiGatewayRequestException(
            $this->dto::class . "->$propertyKey: не получилось получить значение подходящее для Post или Put запроса: " . json_encode($propertyValue)
        );
    }

    /** @throws VetmanagerApiGatewayRequestException */
    private function getOnlyDateFromDateTime()
    {
        $propertyKey = $this->propertyKey;
        $propertyValue = $this->dto->$propertyKey;

        if (is_null($propertyValue)) {
            return null;
        }

        if ($propertyValue instanceof DateTime) {
            return $propertyValue->format('Y-m-d');
        }

        throw new VetmanagerApiGatewayRequestException(
            $this->dto::class . "->$propertyKey: гидратор ожидал увидеть DateTime или null. Было: " . json_encode($propertyValue)
        );
    }
}
