<?php

namespace VetmanagerApiGateway\DTO\ClientType;

use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

interface ClientTypeOnlyDtoInterface
{
    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setId(int $value): static;

    public function getTitle(): string;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTitle(string $value): static;
}