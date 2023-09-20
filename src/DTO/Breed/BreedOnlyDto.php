<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Breed;

use VetmanagerApiGateway\ApiDataInterpreter\ToInt;
use VetmanagerApiGateway\ApiDataInterpreter\ToString;
use VetmanagerApiGateway\DTO\AbstractDTO;

class BreedOnlyDto extends AbstractDTO implements BreedOnlyDtoInterface
{
    /**
     * @param int|null $id
     * @param string|null $title
     * @param int|null $pet_type_id
     */
    public function __construct(
        public ?int $id,
        public ?string $title,
        public ?int $pet_type_id
    ) {
    }

    public function getId(): int
    {
        return (new ToInt($this->id))->getPositiveIntOrThrow();
    }

    public function getTitle(): string
    {
        return ToString::fromStringOrNull($this->title)->getStringOrThrowIfNull();
    }

    public function getPetTypeId(): int
    {
        return (new ToInt($this->pet_type_id))->getPositiveIntOrThrow();
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
