<?php

namespace VetmanagerApiGateway\DTO\Property;

use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

interface PropertyOnlyDtoInterface
{
    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int;

    /** Default: '' */
    public function getName(): ?string;

    public function getValue(): ?string;

    public function getTitle(): ?string;

    /** @return ?positive-int Default: '0' (вместо него отдаем null)
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getClinicId(): ?int;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setId(int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setName(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setValue(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTitle(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setClinicId(?int $value): static;
}