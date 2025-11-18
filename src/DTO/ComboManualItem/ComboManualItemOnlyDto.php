<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\ComboManualItem;

use VetmanagerApiGateway\ApiDataInterpreter\ToBool;
use VetmanagerApiGateway\ApiDataInterpreter\ToInt;
use VetmanagerApiGateway\ApiDataInterpreter\ToString;
use VetmanagerApiGateway\DTO\AbstractDTO;

class ComboManualItemOnlyDto extends AbstractDTO implements ComboManualItemOnlyDtoInterface
{
    /**
     * @param int|string|null $id
     * @param int|string|null $combo_manual_id
     * @param string|null $title
     * @param string|null $value
     * @param string|null $dop_param1
     * @param string|null $dop_param2
     * @param string|null $dop_param3
     * @param int|string|null $is_active
     */
    public function __construct(
        protected int|string|null $id,
        protected int|string|null $combo_manual_id,
        protected ?string         $title,
        protected ?string         $value,
        protected ?string         $dop_param1,
        protected ?string         $dop_param2,
        protected ?string         $dop_param3,
        protected int|string|null $is_active
    ) {
    }

    public function getId(): int
    {
        return (ToInt::fromIntOrStringOrNull($this->id))->getPositiveIntOrThrow();
    }

    public function getComboManualId(): int
    {
        return (ToInt::fromIntOrStringOrNull($this->combo_manual_id))->getPositiveIntOrThrow();
    }

    public function getTitle(): string
    {
        return ToString::fromStringOrNull($this->title)->getStringEvenIfNullGiven();
    }

    public function getValue(): string
    {
        return ToString::fromStringOrNull($this->value)->getStringEvenIfNullGiven();
    }

    public function getDopParam1(): string
    {
        return ToString::fromStringOrNull($this->dop_param1)->getStringEvenIfNullGiven();
    }

    public function getDopParam2(): string
    {
        return ToString::fromStringOrNull($this->dop_param2)->getStringEvenIfNullGiven();
    }

    public function getDopParam3(): string
    {
        return ToString::fromStringOrNull($this->dop_param3)->getStringEvenIfNullGiven();
    }

    public function getIsActive(): bool
    {
        return ToBool::fromIntOrNull($this->is_active)->getBoolOrThrowIfNull();
    }

    public function setComboManualId(int $value): static
    {
        return self::setPropertyFluently($this, 'combo_manual_id', $value);
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
        return self::setPropertyFluently($this, 'is_active', (int)$value);
    }
}
