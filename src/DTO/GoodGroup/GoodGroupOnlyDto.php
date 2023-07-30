<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\GoodGroup;

use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Hydrator\ApiBool;
use VetmanagerApiGateway\Hydrator\ApiFloat;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;

class GoodGroupOnlyDto extends AbstractDTO implements GoodGroupOnlyDtoInterface
{
    /**
     * @param string|null $id
     * @param string|null $title
     * @param string|null $is_service Default: 0
     * @param string|null $markup
     * @param string|null $is_show_in_vaccines Default: 0
     * @param string|null $price_id
     */
    public function __construct(
        protected ?string $id,
        protected ?string $title,
        protected ?string $is_service,
        protected ?string $markup,
        protected ?string $is_show_in_vaccines,
        protected ?string $price_id
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

    public function getIsService(): bool
    {
        return ApiBool::fromStringOrNull($this->is_service)->getBoolOrThrowIfNull();
    }

    public function getMarkup(): ?float
    {
        return ApiFloat::fromStringOrNull($this->markup)->getNonZeroFloatOrNull();
    }


    public function getIsShowInVaccines(): bool
    {
        return ApiBool::fromStringOrNull($this->is_show_in_vaccines)->getBoolOrThrowIfNull();
    }

    public function getPriceId(): ?int
    {
        return ApiInt::fromStringOrNull($this->price_id)->getPositiveIntOrNull();
    }

    public function setId(?int $value): static
    {
        return self::setPropertyFluently($this, 'id', is_null($value) ? null : (string)$value);
    }

    public function setTitle(?string $value): static
    {
        return self::setPropertyFluently($this, 'title', $value);
    }

    public function setIsService(?bool $value): static
    {
        return self::setPropertyFluently($this, 'is_service', is_null($value) ? null : (string)(int)$value);
    }

    public function setMarkup(?float $value): static
    {
        return self::setPropertyFluently($this, 'markup', is_null($value) ? null : (string)$value);
    }

    public function setIsShowInVaccines(?bool $value): static
    {
        return self::setPropertyFluently($this, 'is_show_in_vaccines', is_null($value) ? null : (string)(int)$value);
    }

    public function setPriceId(?int $value): static
    {
        return self::setPropertyFluently($this, 'price_id', is_null($value) ? null : (string)$value);
    }

    /** @param array{
     *     "id": string,
     *     "title": string,
     *     "is_service": string,
     *     "markup": ?string,
     *     "is_show_in_vaccines": string,
     *     "price_id": ?string
     * } $originalDataArray
     */
}
