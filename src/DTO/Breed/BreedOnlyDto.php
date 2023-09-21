<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Breed;

use VetmanagerApiGateway\ApiDataInterpreter\ToInt;
use VetmanagerApiGateway\ApiDataInterpreter\ToString;
use VetmanagerApiGateway\DTO\AbstractDTO;

class BreedOnlyDto extends AbstractDTO implements BreedOnlyDtoInterface
{
    /**
     * @param int|string|null $id
     * @param string|null $title
     * @param int|string|null $pet_type_id
     */
    public function __construct(
        public int|string|null $id,
        public ?string         $title,
        public int|string|null $pet_type_id
    )
    {
    }

    public function getId(): int
    {
        return (ToInt::fromIntOrStringOrNull($this->id))->getPositiveIntOrThrow();
    }

    public function getTitle(): string
    {
        return ToString::fromStringOrNull($this->title)->getStringOrThrowIfNull();
    }

    public function getPetTypeId(): int
    {
        return (ToInt::fromIntOrStringOrNull($this->pet_type_id))->getPositiveIntOrThrow();
    }

    public function setTitle(?string $value): static
    {
        return self::setPropertyFluently($this, 'title', $value);
    }

    public function setPetTypeId(?int $value): static
    {
        return self::setPropertyFluently($this, 'pet_type_id', is_null($value) ? null : $value);
    }

//    /** @param array{
//     *       id: string,
//     *       title: string,
//     *       pet_type_id: string,
//     *       petType?: array
//     *   }
//     */
}
