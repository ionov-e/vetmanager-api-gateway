<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\ComboManualName;

use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;
use VetmanagerApiGateway\Hydrator\ApiBool;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;

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
        return ApiInt::fromStringOrNull($this->id)->getPositiveInt();
    }

    public function getTitle(): string
    {
        return ApiString::fromStringOrNull($this->title)->getNonEmptyStringOrThrow();
    }

    public function getIsReadonly(): bool
    {
        return ApiBool::fromStringOrNull($this->is_readonly)->getBoolOrThrowIfNull();
    }

    public function getName(): string
    {
        return ApiString::fromStringOrNull($this->name)->getNonEmptyStringOrThrow();
    }

    public function setId(int $value): static
    {
        return self::setPropertyFluently($this, 'id', $value ? (string)$value : "0");
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

    /** @param array{
     *       id: string,
     *       title: string,
     *       is_readonly: string,
     *       name: string,
     *       comboManualItems?: array
     *   } $originalDataArray 'comboManualItems' не используем
     */
}
