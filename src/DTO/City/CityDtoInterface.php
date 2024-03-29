<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\City;

use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

interface CityDtoInterface
{
    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int;

    public function getTitle(): string;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTitle(string $value): static;

    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getTypeId(): int;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTypeId(int $value): static;
}