<?php

namespace VetmanagerApiGateway\DTO\PetType;

use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

interface PetTypeOnlyDtoInterface
{
    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int;

    public function getTitle(): string;

    /** Default: '' */
    public function getPicture(): string;

    public function getType(): string;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setId(int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTitle(string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setPicture(string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setType(string $value): static;
}