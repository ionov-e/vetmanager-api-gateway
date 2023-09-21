<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\GoodGroup;

use VetmanagerApiGateway\ApiDataInterpreter\ToBool;
use VetmanagerApiGateway\ApiDataInterpreter\ToFloat;
use VetmanagerApiGateway\ApiDataInterpreter\ToInt;
use VetmanagerApiGateway\ApiDataInterpreter\ToString;
use VetmanagerApiGateway\DTO\AbstractDTO;

class GoodGroupOnlyDto extends AbstractDTO implements GoodGroupOnlyDtoInterface
{
    /**
     * @param int|string|null $id
     * @param string|null $title
     * @param int|string|null $is_service Default: 0
     * @param string|null $markup
     * @param int|string|null $is_show_in_vaccines Default: 0
     * @param int|string|null $price_id
     */
    public function __construct(
        protected int|string|null $id,
        protected ?string         $title,
        protected int|string|null $is_service,
        protected ?string         $markup,
        protected int|string|null $is_show_in_vaccines,
        protected int|string|null $price_id
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

    public function getIsService(): bool
    {
        return ToBool::fromIntOrNull($this->is_service)->getBoolOrThrowIfNull();
    }

    public function getMarkup(): ?float
    {
        return ToFloat::fromStringOrNull($this->markup)->getNonZeroFloatOrNull();
    }


    public function getIsShowInVaccines(): bool
    {
        return ToBool::fromIntOrNull($this->is_show_in_vaccines)->getBoolOrThrowIfNull();
    }

    public function getPriceId(): ?int
    {
        return (ToInt::fromIntOrStringOrNull($this->price_id))->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function setTitle(?string $value): static
    {
        return self::setPropertyFluently($this, 'title', $value);
    }

    public function setIsService(?bool $value): static
    {
        return self::setPropertyFluently($this, 'is_service', is_null($value) ? null : (int)$value);
    }

    public function setMarkup(?float $value): static
    {
        return self::setPropertyFluently($this, 'markup', is_null($value) ? null : (string)$value);
    }

    public function setIsShowInVaccines(?bool $value): static
    {
        return self::setPropertyFluently($this, 'is_show_in_vaccines', (int)$value);
    }

    public function setPriceId(?int $value): static
    {
        return self::setPropertyFluently($this, 'price_id', $value);
    }

//    /** @param array{
//     *     "id": string,
//     *     "title": string,
//     *     "is_service": string,
//     *     "markup": ?string,
//     *     "is_show_in_vaccines": string,
//     *     "price_id": ?string
//     * } $originalDataArray
//     */
}
