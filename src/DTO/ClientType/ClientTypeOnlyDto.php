<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\ClientType;

use VetmanagerApiGateway\ApiDataInterpreter\ToInt;
use VetmanagerApiGateway\ApiDataInterpreter\ToString;
use VetmanagerApiGateway\DTO\AbstractDTO;

class ClientTypeOnlyDto extends AbstractDTO implements ClientTypeOnlyDtoInterface
{
    /**
     * @param int|string|null $id
     * @param string|null $title
     */
    public function __construct(
        protected int|string|null $id,
        protected ?string         $title
    ) {
    }

    public function getId(): int
    {
        return (ToInt::fromIntOrStringOrNull($this->id))->getPositiveIntOrThrow();
    }

    public function getTitle(): string
    {
        return ToString::fromStringOrNull($this->title)->getStringEvenIfNullGiven();
    }

    public function setTitle(string $value): static
    {
        return self::setPropertyFluently($this, 'title', $value);
    }
}
