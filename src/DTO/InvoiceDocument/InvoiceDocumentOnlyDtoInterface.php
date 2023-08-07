<?php

namespace VetmanagerApiGateway\DTO\InvoiceDocument;

use DateTime;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

interface InvoiceDocumentOnlyDtoInterface
{
    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int;

    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getInvoiceId(): int;

    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getGoodId(): int;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getQuantity(): ?float;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getPrice(): float;

    /** @return ?positive-int Default: '0'
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getResponsibleUserId(): ?int;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getIsDefaultResponsible(): bool;

    /** @return positive-int Default in BD: '0'. Но не видел 0
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getSaleParamId(): int;

    /** @return ?positive-int Default: '0'
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getTagId(): ?int;

    public function getDiscountTypeAsString(): ?string;

    public function getDiscountTypeAsEnum(): ?DiscountTypeEnum;

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getDiscountDocumentId(): ?int;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getDiscountPercent(): ?float;

    /** Default: 0.00000000
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getDefaultPrice(): ?float;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getCreateDateAsString(): string;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getCreateDateAsDateTime(): DateTime;

    public function getDiscountCause(): string;

    /** @return ?positive-int Default: '0'
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getFixedDiscountId(): ?int;

    /** @return ?positive-int Default: '0'
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getFixedDiscountPercent(): ?int;

    /** @return ?positive-int Default: '0'
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getFixedIncreaseId(): ?int;

    /** @return ?positive-int Default: '0'
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getFixedIncreasePercent(): ?int;

    /** Default: "0.0000000000"
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getPrimeCost(): float;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setInvoiceId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setGoodId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setQuantity(?float $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setPrice(?float $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setResponsibleUserId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setIsDefaultResponsible(?bool $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setSaleParamId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTagId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDiscountType(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDiscountDocumentId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDiscountPercent(?float $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDefaultPrice(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCreateDateAsString(string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCreateDateAsDateTime(DateTime $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDiscountCause(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setFixedDiscountId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setFixedDiscountPercent(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setFixedIncreaseId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setFixedIncreasePercent(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setPrimeCost(?float $value): static;
}