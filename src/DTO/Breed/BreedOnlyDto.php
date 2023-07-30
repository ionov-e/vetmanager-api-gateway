<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Breed;

use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;

class BreedOnlyDto extends AbstractDTO implements BreedOnlyDtoInterface
{
    /**
     * @param string|null $id
     * @param string|null $title
     * @param string|null $pet_type_id
     */
    public function __construct(
        public ?string $id,
        public ?string $title,
        public ?string $pet_type_id
    ) {
    }

    public function getId(): int
    {
        return ApiInt::fromStringOrNull($this->id)->getPositiveInt();
    }

    public function getTitle(): string
    {
        return ApiString::fromStringOrNull($this->title)->getStringOrThrowIfNull();
    }

    public function getPetTypeId(): int
    {
        return ApiInt::fromStringOrNull($this->pet_type_id)->getPositiveInt();
    }

    public function setId(?string $value): static
    {
        return self::setPropertyFluently($this, 'id', (string)$value);
    }

    public function setTitle(?string $value): static
    {
        return self::setPropertyFluently($this, 'title', (string)$value);
    }

    public function setPetTypeId(?string $value): static
    {
        return self::setPropertyFluently($this, 'pet_type_id', (string)$value);
    }

//    /** @param array{
//     *       id: string,
//     *       title: string,
//     *       pet_type_id: string,
//     *       petType?: array
//     *   }
//     */
}
