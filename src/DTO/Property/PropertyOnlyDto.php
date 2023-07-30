<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Property;

use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;

class PropertyOnlyDto extends AbstractDTO implements PropertyOnlyDtoInterface
{
    /**
     * @param string|null $id
     * @param string|null $property_name
     * @param string|null $property_value
     * @param string|null $property_title
     * @param string|null $clinic_id
     */
    public function __construct(
        protected ?string $id,
        protected ?string $property_name,
        protected ?string $property_value,
        protected ?string $property_title,
        protected ?string $clinic_id
    ) {
    }

    public function getId(): int
    {
        return ApiInt::fromStringOrNull($this->id)->getPositiveInt();
    }

    public function getName(): ?string
    {
        return ApiString::fromStringOrNull($this->property_name)->getStringEvenIfNullGiven();
    }

    public function getValue(): ?string
    {
        return ApiString::fromStringOrNull($this->property_value)->getStringEvenIfNullGiven();
    }

    public function getTitle(): ?string
    {
        return ApiString::fromStringOrNull($this->property_title)->getStringEvenIfNullGiven();
    }

    public function getClinicId(): ?int
    {
        return ApiInt::fromStringOrNull($this->clinic_id)->getPositiveIntOrNull();
    }

    public function setId(int $value): static
    {
        return self::setPropertyFluently($this, 'id', (string)$value);
    }

    public function setName(?string $value): static
    {
        return self::setPropertyFluently($this, 'property_name', $value);
    }

    public function setValue(?string $value): static
    {
        return self::setPropertyFluently($this, 'property_value', $value);
    }

    public function setTitle(?string $value): static
    {
        return self::setPropertyFluently($this, 'property_title', $value);
    }

    public function setClinicId(?int $value): static
    {
        return self::setPropertyFluently($this, 'clinic_id', is_null($value) ? null : (string)$value);
    }

    /** @param array{
     *     "id": string,
     *     "property_name": string,
     *     "property_value": string,
     *     "property_title": ?string,
     *     "clinic_id": string
     * } $originalDataArray
     */
}
