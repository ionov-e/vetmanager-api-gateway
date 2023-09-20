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
     * @param int|null $id
     * @param string|null $title
     * @param int|null $is_readonly
     * @param string|null $name
     */
    public function __construct(
        protected ?int $id,
        protected ?string $title,
        protected ?int $is_readonly,
        protected ?string $name
    )
    {
    }

    public function getId(): int
    {
        return (new ToInt($this->id))->getPositiveIntOrThrow();
    }

    public function getTitle(): string
    {
        return ToString::fromStringOrNull($this->title)->getNonEmptyStringOrThrow();
    }

    public function getIsReadonly(): bool
    {
        return ToBool::fromIntOrNull($this->is_readonly)->getBoolOrThrowIfNull();
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
        return self::setPropertyFluently($this, 'is_readonly', (int)$value);
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
