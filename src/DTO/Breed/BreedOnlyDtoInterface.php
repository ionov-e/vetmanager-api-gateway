<?php

namespace VetmanagerApiGateway\DTO\Breed;

use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

interface BreedOnlyDtoInterface
{
    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int;

    /** @return non-empty-string
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getTitle(): string;

    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getPetTypeId(): int;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setId(int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTitle(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setPetTypeId(?int $value): static;
}