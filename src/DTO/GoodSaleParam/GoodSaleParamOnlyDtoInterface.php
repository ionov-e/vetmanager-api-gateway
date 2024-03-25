<?php

namespace VetmanagerApiGateway\DTO\GoodSaleParam;

use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

interface GoodSaleParamOnlyDtoInterface
{
    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int;

    /**
     * @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getGoodId(): ?int;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getPrice(): ?float;

    /** Default: 1
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getCoefficient(): float|null;

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getUnitSaleId(): ?int;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getMinPrice(): ?float;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getMaxPrice(): ?float;

    public function getBarcode(): string;

    /** Default: 'active' */
    public function getStatus(): StatusEnum;

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getClinicId(): ?int;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getMarkup(): ?float;

    /** Default: 'fixed' */
    public function getPriceFormationAsEnum(): PriceFormationEnum;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setGoodId(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setPrice(?float $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCoefficient(?float $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setUnitSaleId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setMinPrice(?float $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setMaxPrice(?float $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setBarcode(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setStatusFromString(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setStatusFromEnum(StatusEnum $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setClinicId(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setMarkup(?float $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setPriceFormationFromString(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setPriceFormationFromEnum(PriceFormationEnum $value): static;
}