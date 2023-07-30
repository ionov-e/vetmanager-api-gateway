<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\PetType;

use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;

class PetTypeOnlyDto extends AbstractDTO implements PetTypeOnlyDtoInterface
{
    /**
     * @param string|null $id
     * @param string|null $title
     * @param string|null $picture
     * @param string|null $type
     */
    public function __construct(
        public ?string $id,
        public ?string $title,
        public ?string $picture,
        public ?string $type
    ) {
    }

    public function getId(): int
    {
        return ApiInt::fromStringOrNull($this->id)->getPositiveInt();
    }

    public function getTitle(): string
    {
        return ApiString::fromStringOrNull($this->title)->getStringEvenIfNullGiven();
    }

    public function getPicture(): string
    {
        return ApiString::fromStringOrNull($this->picture)->getStringEvenIfNullGiven();
    }

    public function getType(): string
    {
        return ApiString::fromStringOrNull($this->type)->getStringEvenIfNullGiven();
    }

    public function setId(int $value): static
    {
        return self::setPropertyFluently($this, 'id', (string)$value);
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
