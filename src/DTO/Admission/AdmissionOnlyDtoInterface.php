<?php

namespace VetmanagerApiGateway\DTO\Admission;

use DateInterval;
use DateTime;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

interface AdmissionOnlyDtoInterface
{
    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getAdmissionDateAsDateTime(): DateTime;

    /** Примеры: "На основании медкарты", "Запись из модуля, к свободному доктору, по услуге Ампутация пальцев" */
    public function getDescription(): string;

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getClientId(): ?int;

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getPetId(): ?int;

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getUserId(): ?int;

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getTypeId(): ?int;

    /**
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getAdmissionLengthAsDateInterval(): ?DateInterval;

    public function getStatusAsEnum(): ?StatusEnum;

    /** @return ?positive-int В БД встречается "0" - переводим в null
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getClinicId(): ?int;

    /** Насколько я понял, означает: 'Прием без планирования'
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getIsDirectDirection(): bool;

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getCreatorId(): ?int;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getCreateDateAsDateTime(): DateTime;

    /** Тут судя по коду, можно привязать еще одного доктора, т.е. ID от {@see UserOnly}. Какой-то врач-помощник что ли
     * @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getEscortId(): ?int;

    /** Искал по всем БД: находил только "vetmanager" и "" или null (редко. Пустые перевожу в null) */
    public function getReceptionWriteChannel(): string;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getIsAutoCreate(): bool;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getInvoicesSum(): ?float;

    public function setId(int $value): static;

    public function setAdmissionDateFromString(string $value): static;

    public function setAdmissionDateFromDateTime(DateTime $value): static;

    public function setDescription(string $value): static;

    public function setClientId(int $value): static;

    public function setPatientId(int $value): static;

    public function setUserId(int $value): static;

    public function setTypeId(int $value): static;

    public function setAdmissionLengthFromString(string $value): static;

    public function setAdmissionLengthFromDateInterval(DateInterval $value): static;

    public function setStatusFromString(?string $value): static;

    public function setStatusFromEnum(StatusEnum $value): static;

    public function setClinicId(int $value): static;

    public function setIsDirectDirection(bool $value): static;

    public function setCreatorId(int $value): static;

    public function setCreateDateFromString(string $value): static;

    public function setCreateDateFromDateTime(DateTime $value): static;

    public function setEscortId(int $value): static;

    public function setReceptionWriteChannel(string $value): static;

    public function setIsAutoCreate(bool $value): static;

    public function setInvoicesSum(?float $value): static;
}