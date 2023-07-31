<?php

namespace VetmanagerApiGateway\DTO\Unit;

use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

interface UnitOnlyDtoInterface
{
    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int;

    public function getTitle(): ?string;

    /** Default: 'active' */
    public function getStatus(): StatusEnum;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setId(int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTitle(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setStatusAsString(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setStatusAsEnum(StatusEnum $value): static;
}