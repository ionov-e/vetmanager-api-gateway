<?php

namespace VetmanagerApiGateway\DTO\MedicalCard;

use DateTime;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

interface MedicalCardOnlyDtoInterface
{
    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int;

    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getPetId(): int;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getDateCreateAsString(): string;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getDateCreateAsDateTime(): DateTime;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getDateEditAsString(): string;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getDateEditAsDateTime(): DateTime;

    /** Сюда приходит либо "0", либо JSON типа: "[ {"id":32,"type":1}, {"id":35,"type":1}, {"id":77,"type":1} ]". 0 переводим в '' */
    public function getDiagnose(): string;

    /** Может прийти пустая строка, может просто строка, может HTML */
    public function getRecommendation(): string;

    /**
     * @return ?positive-int Возможно null никогда не будет. Invoice ID (таблица invoice)
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getInvoiceId(): ?int;

    /** Получается через: LEFT JOIN combo_manual_items ci ON ci.combo_manual_id = {$reasonId} AND ci.value = m.admission_type
     * @return ?positive-int Возможно null никогда не будет
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getAdmissionTypeId(): ?int;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getWeight(): ?float;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getTemperature(): ?float;

    /**
     * Получается через: LEFT JOIN combo_manual_items ci2 ON ci2.combo_manual_id = 2 AND ci2.value = m.meet_result_id
     * @return ?positive-int Возможно null никогда не будет. Default: 0 (переводим в null)
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getMeetResultId(): ?int;

    /** Может быть просто строка, а может HTML-блок */
    public function getDescription(): string;

    /** Получается через: LEFT JOIN admission ad ON ad.id = m.next_meet_id
     * @return ?positive-int Возможно null никогда не будет. Default: 0 - переводим в null.
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getNextMeetId(): ?int;

    /** @return ?positive-int Возможно null никогда не будет. Default: 0 - переводим в null
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getUserId(): ?int;

    /** Может можно отдельно запрашивать его?
     * @return ?positive-int Возможно null никогда не будет. Default: 0 - переводим в null.
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getCreatorId(): ?int;

    /** Default: 'active' */
    public function getStatusAsString(): string;

    /** Default: 'active' */
    public function getStatusAsEnum(): StatusEnum;

    /** @return ?positive-int Возможно null никогда не будет. Default: 0 - переводим в null
     * Вроде это ID из модуля задач. Пока непонятно
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getCallingId(): ?int;

    /** @return ?positive-int Возможно null никогда не будет. Default: 0 - переводим в null
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getAdmissionId(): ?int;

    /** Пример: "Анемия;\nАнорексия, кахексия;\nАтопия" */
    public function getDiagnoseText(): string;

    /** Пример: "Анемия (Окончательные);\nАнорексия, кахексия (Окончательные);\nАтопия (Окончательные)" */
    public function getDiagnoseTypeText(): string;

    /** @return ?positive-int Default: 0 - переводим в null. Нашел 6 клиник, где не есть 0
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getClinicId(): ?int;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setPetId(int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDateCreateFromString(string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDateCreateFromDateTime(DateTime $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDateEditFromString(string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDateEditFromDateTime(DateTime $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDiagnose(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setRecommendation(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setInvoiceId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setAdmissionTypeId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setWeight(?float $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTemperature(?float $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setMeetResultId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDescription(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setNextMeetId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setUserId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCreatorId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setStatusFromString(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setStatusFromEnum(StatusEnum $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCallingId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setAdmissionId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDiagnoseText(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDiagnoseTypeText(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setClinicId(?int $value): static;
}