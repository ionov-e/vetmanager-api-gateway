<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Property;

use VetmanagerApiGateway\ApiDataInterpreter\ToInt;
use VetmanagerApiGateway\ApiDataInterpreter\ToString;
use VetmanagerApiGateway\DTO\AbstractDTO;

class PropertyOnlyDto extends AbstractDTO implements PropertyOnlyDtoInterface
{
    /**
     * @param int|null $id
     * @param string|null $property_name
     * @param string|null $property_value
     * @param string|null $property_title
     * @param int|null $clinic_id
     */
    public function __construct(
        protected ?int $id,
        protected ?string $property_name,
        protected ?string $property_value,
        protected ?string $property_title,
        protected ?int $clinic_id
    ) {
    }

    public function getId(): int
    {
        return (new ToInt($this->id))->getPositiveIntOrThrow();
    }

    public function getName(): ?string
    {
        return ToString::fromStringOrNull($this->property_name)->getStringEvenIfNullGiven();
    }

    public function getValue(): ?string
    {
        return ToString::fromStringOrNull($this->property_value)->getStringEvenIfNullGiven();
    }

    public function getTitle(): ?string
    {
        return ToString::fromStringOrNull($this->property_title)->getStringEvenIfNullGiven();
    }

    public function getClinicId(): ?int
    {
        return (new ToInt($this->clinic_id))->getPositiveIntOrNullOrThrowIfNegative();
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
        return self::setPropertyFluently($this, 'clinic_id', $value);
    }

//    /** @param array{
//     *     "id": string,
//     *     "property_name": string,
//     *     "property_value": string,
//     *     "property_title": ?string,
//     *     "clinic_id": string
//     * } $originalDataArray
//     */
}
