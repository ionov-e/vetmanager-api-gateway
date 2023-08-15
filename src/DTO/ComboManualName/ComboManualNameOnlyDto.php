<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\ComboManualName;

use VetmanagerApiGateway\ApiDataInterpreter\ToBool;
use VetmanagerApiGateway\ApiDataInterpreter\ToInt;
use VetmanagerApiGateway\ApiDataInterpreter\ToString;
use VetmanagerApiGateway\DTO\AbstractDTO;

class ComboManualNameOnlyDto extends AbstractDTO implements ComboManualNameOnlyDtoInterface
{
    /**
     * @param string|null $id
     * @param string|null $title
     * @param string|null $is_readonly
     * @param string|null $name
     */
    public function __construct(
        protected ?string $id,
        protected ?string $title,
        protected ?string $is_readonly,
        protected ?string $name
    )
    {
    }

    public function getId(): int
    {
        return ToInt::fromStringOrNull($this->id)->getPositiveIntOrThrow();
    }

    public function getTitle(): string
    {
        return ToString::fromStringOrNull($this->title)->getNonEmptyStringOrThrow();
    }

    public function getIsReadonly(): bool
    {
        return ToBool::fromStringOrNull($this->is_readonly)->getBoolOrThrowIfNull();
    }

    public function getName(): string
    {
        return ToString::fromStringOrNull($this->name)->getNonEmptyStringOrThrow();
    }

    public function setTitle(?string $value): static
    {
        return self::setPropertyFluently($this, 'title', $value);
    }

    public function setIsReadonly(bool $value): static
    {
        return self::setPropertyFluently($this, 'is_readonly', (string)(int)$value);
    }

    public function setName(?string $value): static
    {
        return self::setPropertyFluently($this, 'name', $value);
    }

//    /** @param array{
//     *       id: string,
//     *       title: string,
//     *       is_readonly: string,
//     *       name: string,
//     *       comboManualItems?: array
//     *   } $originalDataArray 'comboManualItems' не используем
//     */
}
