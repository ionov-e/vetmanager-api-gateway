<?php

namespace VetmanagerApiGateway\DTO\Role;

use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

interface RoleOnlyDtoInterface
{
    /** @throws VetmanagerApiGatewayResponseException */
    public function getId(): int;

    public function getName(): string;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getIsSuper(): bool;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setId(int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setName(string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setIsSuper(bool $value): static;
}