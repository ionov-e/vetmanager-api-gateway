<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Unit;

use VetmanagerApiGateway\ApiDataInterpreter\ToInt;
use VetmanagerApiGateway\ApiDataInterpreter\ToString;
use VetmanagerApiGateway\DTO\AbstractDTO;

class UnitOnlyDto extends AbstractDTO implements UnitOnlyDtoInterface
{
    /**
     * @param int|string|null $id
     * @param string|null $title
     * @param string|null $status Default: 'active'
     */
    public function __construct(
        protected int|string|null $id,
        protected ?string         $title,
        protected ?string         $status
    ) {
    }

    public function getId(): int
    {
        return (ToInt::fromIntOrStringOrNull($this->id))->getPositiveIntOrThrow();
    }

    public function getTitle(): ?string
    {
        return ToString::fromStringOrNull($this->title)->getStringEvenIfNullGiven();
    }

    public function getStatusAsEnum(): StatusEnum
    {
        return StatusEnum::from($this->status);
    }

    public function getStatusAsString(): string
    {
        return ToString::fromStringOrNull($this->title)->getStringOrThrowIfNull();
    }

    public function setTitle(?string $value): static
    {
        return self::setPropertyFluently($this, 'title', $value);
    }

    public function setStatusFromString(?string $value): static
    {
        return self::setPropertyFluently($this, 'status', $value);
    }

    public function setStatusFromEnum(StatusEnum $value): static
    {
        return self::setPropertyFluently($this, 'status', $value->value);
    }

    //    /** @param array{
    //     *     "id": string,
    //     *     "title": string,
    //     *     "status": string,
    //     * }
    //     */
}
