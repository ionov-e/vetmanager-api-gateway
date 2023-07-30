<?php

namespace VetmanagerApiGateway\DTO\Good;

use DateTime;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

interface GoodOnlyDtoInterface
{
    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int;

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getGroupId(): ?int;

    public function getTitle(): string;

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getUnitId(): ?int;

    /** Default: 1
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getIsWarehouseAccount(): bool;

    /** Default: 1
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getIsActive(): bool;

    public function getCode(): string;

    /** Default: 0
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getIsCall(): bool;

    /** Default: 1
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getIsForSale(): bool;

    public function getBarcode(): string;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getCreateDate(): ?DateTime;

    public function getDescription(): string;

    /** Default: '0.0000000000'
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getPrimeCost(): float;

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getCategoryId(): ?int;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setGroupId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTitle(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setUnitStorageId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setIsWarehouseAccount(?bool $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setIsActive(?bool $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCode(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setIsCall(?bool $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setIsForSale(?bool $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setBarcode(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCreateDateFromString(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCreateDateFromDateTime(DateTime $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDescription(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setPrimeCost(?float $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCategoryId(?int $value): static;
}