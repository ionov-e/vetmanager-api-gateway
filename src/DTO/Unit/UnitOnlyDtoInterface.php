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
    public function getStatusAsEnum(): StatusEnum;

    /** Default: 'active'
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getStatusAsString(): string;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTitle(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setStatusFromString(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setStatusFromEnum(StatusEnum $value): static;
}