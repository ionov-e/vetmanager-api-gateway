<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\CityType;

use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

interface CityTypeDtoInterface
{
    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int;

    public function getTitle(): string;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTitle(string $value): static;
}