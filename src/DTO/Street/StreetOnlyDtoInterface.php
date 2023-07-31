<?php

namespace VetmanagerApiGateway\DTO\Street;

use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

interface StreetOnlyDtoInterface
{
    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int;

    /** Default: '' */
    public function getTitle(): ?string;

    /** @return positive-int В БД Default: '0' (но никогда не видел 0)
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getCityId(): int;

    /** Default: 'street'*/
    public function getTypeAsString(): ?string;

    /** Default: 'street'*/
    public function getTypeAsEnum(): TypeEnum;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setId(int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTitle(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCityId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTypeAsString(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTypeAsEnum(TypeEnum $value): static;
}