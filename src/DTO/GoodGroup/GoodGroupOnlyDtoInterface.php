<?php

namespace VetmanagerApiGateway\DTO\GoodGroup;

use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

interface GoodGroupOnlyDtoInterface
{
    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int;

    public function getTitle(): string;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getIsService(): bool;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getMarkup(): ?float;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getIsShowInVaccines(): bool;

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getPriceId(): ?int;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTitle(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setIsService(?bool $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setMarkup(?float $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setIsShowInVaccines(?bool $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setPriceId(?int $value): static;
}