<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Role;

use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Hydrator\ApiBool;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;

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
        return ApiInt::fromStringOrNull($this->id)->getPositiveInt();
    }

    public function getName(): string
    {
        return ApiString::fromStringOrNull($this->name)->getStringEvenIfNullGiven();
    }

    public function getIsSuper(): bool
    {
        return ApiBool::fromStringOrNull($this->super)->getBoolOrThrowIfNull();
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
