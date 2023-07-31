<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\ClientType;

use VetmanagerApiGateway\ApiDataInterpreter\ToInt;
use VetmanagerApiGateway\ApiDataInterpreter\ToString;
use VetmanagerApiGateway\DTO\AbstractDTO;

class ClientTypeOnlyDto extends AbstractDTO implements ClientTypeOnlyDtoInterface
{
    /**
     * @param string|null $id
     * @param string|null $title
     */
    public function __construct(
        protected ?string $id,
        protected ?string $title
    )
    {
    }

    public function getId(): int
    {
        return ToInt::fromStringOrNull($this->id)->getPositiveInt();
    }

    public function setId(int $value): static
    {
        return self::setPropertyFluently($this, 'id', (string)$value);
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