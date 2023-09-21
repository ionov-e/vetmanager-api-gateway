<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\PetType;

use VetmanagerApiGateway\ApiDataInterpreter\ToInt;
use VetmanagerApiGateway\ApiDataInterpreter\ToString;
use VetmanagerApiGateway\DTO\AbstractDTO;

class PetTypeOnlyDto extends AbstractDTO implements PetTypeOnlyDtoInterface
{
    /**
     * @param int|string|null $id
     * @param string|null $title
     * @param string|null $picture
     * @param string|null $type
     */
    public function __construct(
        public int|string|null $id,
        public ?string         $title,
        public ?string         $picture,
        public ?string         $type
    )
    {
    }

    public function getId(): int
    {
        return (ToInt::fromIntOrStringOrNull($this->id))->getPositiveIntOrThrow();
    }

    public function getTitle(): string
    {
        return ToString::fromStringOrNull($this->title)->getStringEvenIfNullGiven();
    }

    public function getPicture(): string
    {
        return ToString::fromStringOrNull($this->picture)->getStringEvenIfNullGiven();
    }

    public function getType(): string
    {
        return ToString::fromStringOrNull($this->type)->getStringEvenIfNullGiven();
    }

    public function setTitle(string $value): static
    {
        return self::setPropertyFluently($this, 'title', $value);
    }

    public function setPicture(string $value): static
    {
        return self::setPropertyFluently($this, 'picture', $value);
    }

    public function setType(string $value): static
    {
        return self::setPropertyFluently($this, 'type', $value);
    }

//    /** @param array{
//     *     id: string,
//     *     title: string,
//     *     picture: string,
//     *     type: ?string,
//     * } $originalDataArray
//     */
}
