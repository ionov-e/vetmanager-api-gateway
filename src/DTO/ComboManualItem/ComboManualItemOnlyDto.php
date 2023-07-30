<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\ComboManualItem;

use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Hydrator\ApiBool;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;

class ComboManualItemOnlyDto extends AbstractDTO implements ComboManualItemOnlyDtoInterface
{
    /**
     * @param string|null $id
     * @param string|null $combo_manual_id
     * @param string|null $title
     * @param string|null $value
     * @param string|null $dop_param1
     * @param string|null $dop_param2
     * @param string|null $dop_param3
     * @param string|null $is_active
     */
    public function __construct(
        protected ?string $id,
        protected ?string $combo_manual_id,
        protected ?string $title,
        protected ?string $value,
        protected ?string $dop_param1,
        protected ?string $dop_param2,
        protected ?string $dop_param3,
        protected ?string $is_active
    )
    {
    }

    public function getId(): int
    {
        return ApiInt::fromStringOrNull($this->id)->getPositiveInt();
    }

    public function getComboManualId(): int
    {
        return ApiInt::fromStringOrNull($this->combo_manual_id)->getPositiveInt();
    }

    public function getTitle(): string
    {
        return ApiString::fromStringOrNull($this->title)->getStringEvenIfNullGiven();
    }

    public function getValue(): string
    {
        return ApiString::fromStringOrNull($this->value)->getStringEvenIfNullGiven();
    }

    public function getDopParam1(): string
    {
        return ApiString::fromStringOrNull($this->dop_param1)->getStringEvenIfNullGiven();
    }

    public function getDopParam2(): string
    {
        return ApiString::fromStringOrNull($this->dop_param2)->getStringEvenIfNullGiven();
    }

    public function getDopParam3(): string
    {
        return ApiString::fromStringOrNull($this->dop_param3)->getStringEvenIfNullGiven();
    }

    public function getIsActive(): bool
    {
        return ApiBool::fromStringOrNull($this->is_active)->getBoolOrThrowIfNull();
    }

    public function setId(int $value): static
    {
        return self::setPropertyFluently($this, 'id', $value ? (string)$value : "0");
    }

    public function setComboManualId(int $value): static
    {
        return self::setPropertyFluently($this, 'combo_manual_id', $value ? (string)$value : "0");
    }

    public function setTitle(?string $value): static
    {
        return self::setPropertyFluently($this, 'title', $value);
    }

    public function setValue(?string $value): static
    {
        return self::setPropertyFluently($this, 'value', $value);
    }

    public function setDopParam1(?string $value): static
    {
        return self::setPropertyFluently($this, 'dop_param1', $value);
    }

    public function setDopParam2(?string $value): static
    {
        return self::setPropertyFluently($this, 'dop_param2', $value);
    }

    public function setDopParam3(?string $value): static
    {
        return self::setPropertyFluently($this, 'dop_param3', $value);
    }

    public function setIsActive(bool $value): static
    {
        return self::setPropertyFluently($this, 'is_active', (string)(int)$value);
    }
}
