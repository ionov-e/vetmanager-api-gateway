<?php

namespace VetmanagerApiGateway\DTO\Invoice;

use DateTime;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

interface InvoiceOnlyDtoInterface
{
    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int;

    /** @return ?positive-int Ни в одной базе не нашел, чтобы было 0 или null
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getUserId(): ?int;

    /** @return positive-int Ни в одной базе не нашел, чтобы было 0 или null
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getClientId(): int;

    /** @return positive-int Ни в одной базе не нашел, чтобы было 0 или null
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getPetId(): int;

    public function getDescription(): ?string;

    /** Округляется до целых. Примеры: "0.0000000000", "-3.0000000000"
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getPercent(): ?float;

    /** Примеры: "0.0000000000", "150.0000000000"
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getAmount(): ?float;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getStatusAsString(): string;

    public function getStatusAsEnum(): \VetmanagerApiGateway\DTO\Invoice\StatusEnum;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getInvoiceDateAsString(): string;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getInvoiceDateAsDateTime(): DateTime;

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getOldId(): ?int;

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getNight(): ?int;

    /** Примеры: "0.0000000000"
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getIncrease(): float;

    /** Примеры: "0.0000000000", "3.0000000000"
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getDiscount(): float;

    /** @return ?positive-int DB default: '0' - переводим в null. В БД не видел 0/null
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getCallId(): ?int;

    /** Примеры: '0.0000000000', "240.0000000000"
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getPaidAmount(): float;

    /** DB default: '0000-00-00 00:00:00'
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getCreateDateAsString(): string;

    /** DB default: '0000-00-00 00:00:00'
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getCreateDateAsDateTime(): DateTime;

    /** Default: 'none'
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getPaymentStatusAsString(): string;

    /** Default: 'none' */
    public function getPaymentStatusAsEnum(): PaymentStatusEnum;

    /** @return ?positive-int DB default: '0' - переводим в null. В БД не видел 0/null
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getClinicId(): ?int;

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getCreatorId(): ?int;

    /** @return ?positive-int Default: '0' - переводим в null. Редко вижу не 0
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getFiscalSectionId(): ?int;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setId(int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setUserId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setClientId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setPetId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDescription(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setPercent(?float $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setAmount(?float $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setStatusFromString(?string $value): static;

    public function setStatusFromEnum(\VetmanagerApiGateway\DTO\Invoice\StatusEnum $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setInvoiceDateFromString(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setInvoiceDateFromDateTime(DateTime $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setOldId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setNight(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setIncrease(?float $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDiscount(?float $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCallId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setPaidAmount(?float $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCreateDateFromString(string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCreateDateFromDateTime(DateTime $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setPaymentStatusFromString(string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setPaymentStatusFromEnum(PaymentStatusEnum $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setClinicId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCreatorId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setFiscalSectionId(?int $value): static;
}