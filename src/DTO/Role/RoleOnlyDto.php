<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Role;

use VetmanagerApiGateway\ApiDataInterpreter\ToBool;
use VetmanagerApiGateway\ApiDataInterpreter\ToInt;
use VetmanagerApiGateway\ApiDataInterpreter\ToString;
use VetmanagerApiGateway\DTO\AbstractDTO;

final class RoleOnlyDto extends AbstractDTO implements RoleOnlyDtoInterface
{
    /**
     * @param string|null $id
     * @param string|null $name
     * @param string|null $super
     */
    public function __construct(
        protected ?string $id,
        protected ?string $name,
        protected ?string $super
    ) {
    }

    public function getId(): int
    {
        return ToInt::fromStringOrNull($this->id)->getPositiveIntOrThrow();
    }

    public function getName(): string
    {
        return ToString::fromStringOrNull($this->name)->getStringEvenIfNullGiven();
    }

    public function getIsSuper(): bool
    {
        return ToBool::fromStringOrNull($this->super)->getBoolOrThrowIfNull();
    }

    public function setId(int $value): static
    {
        return self::setPropertyFluently($this, 'id', (string)$value);
    }

    public function setName(string $value): static
    {
        return self::setPropertyFluently($this, 'name', $value);
    }

    public function setIsSuper(bool $value): static
    {
        return self::setPropertyFluently($this, 'super', is_null($value) ? null : (string)(int)$value);
    }

    /** @param array{
     *     "id": numeric-string,
     *     "name": string,
     *     "super": string,
     * } $originalDataArray
     */
}
