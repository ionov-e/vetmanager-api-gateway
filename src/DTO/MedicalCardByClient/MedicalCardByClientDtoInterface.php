<?php

namespace VetmanagerApiGateway\DTO\MedicalCardByClient;

use DateTime;
use VetmanagerApiGateway\DTO\MedicalCard\StatusEnum;
use VetmanagerApiGateway\DTO\Pet\SexEnum;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

interface MedicalCardByClientDtoInterface
{
    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int;

    public function getDateEditAsString(): ?string;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getDateEditAsDateTime(): DateTime;

    /** Сюда приходит либо "0", либо JSON типа: "[ {"id":32,"type":1}, {"id":35,"type":1}, {"id":77,"type":1} ]". 0 переводим в '' */
    public function getDiagnose(): string;

    /** @return ?positive-int Default: 0 - переводим в null
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getUserId(): ?int;

    /** Default: 'active' */
    public function getStatusAsString(): string;

    /** Default: 'active' */
    public function getStatusAsEnum(): StatusEnum;

    /** Может быть просто строка, а может HTML-блок */
    public function getDescription(): string;

    /** Может прийти пустая строка, может просто строка, может HTML */
    public function getRecommendation(): string;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getWeight(): ?float;

    /**
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getTemperature(): ?float;

    /** @return ?positive-int Default: 0 - переводим в null
     * LEFT JOIN combo_manual_items ci2 ON ci2.combo_manual_id = 2 AND ci2.value = m.meet_result_id. 0 переводим в null
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getMeetResultId(): ?int;

    /** @return ?positive-int Default: 0 - переводим в null
     * {@see AbstractMedicalCard::admissionType} Тип приема
     * LEFT JOIN combo_manual_items ci ON ci.combo_manual_id = {$reasonId} AND ci.value = m.admission_type
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getAdmissionTypeId(): ?int;

    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getPetId(): int;

    public function getPetAlias(): string;

    /** Дата без времени */
    public function getBirthdayAsString(): ?string;

    /** Дата без времени
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getBirthdayAsDateTime(): ?DateTime;

    public function getSexAsString(): ?string;

    public function getSexAsEnum(): SexEnum;

    public function getPetNote(): string;

    public function getPetTypeTitle(): string;

    public function getBreedTitle(): string;

    /** @return ?positive-int Default: 0 - переводим в null. Не уверен, что вообще можем получить 0 или null
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getClientId(): ?int;

    public function getFirstName(): string;

    public function getLastName(): string;

    public function getMiddleName(): string;

    public function getOwnerPhone(): string;

    public function getUserLogin(): string;

    public function getUserFirstName(): string;

    public function getUserLastName(): string;

    public function getUserMiddleName(): string;

    /** Будет False, если в таблице special_studies_medcard_data будет хоть одна запись с таким же medcard_id {@see self::getId()}
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getIsEditable(): bool;

    /** Пример: "Повторный прием"
     *
     * В таблице combo_manual_items ищет кортеж с combo_manual_id = 2 и value = {@see self::getMeetResultId()}. Из строки возвращается title
     */
    public function getMeetResultTitle(): string;

    /** Пример: "Вакцинация", "Хирургия", "Первичный" или "Вторичный"
     *
     * В медкарте есть 'admission_type' с ID. Дальше идет в таблицу combo_manual_items ищет строку с combo_manual_id = 'ID for admission type' и 'value' из admission type ID. Возвращает значение из столбца title. */
    public function getAdmissionTypeTitle(): string;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDateEditFromString(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDateEditFromDateTime(DateTime $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDiagnose(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setUserId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setStatusFromString(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setStatusFromEnum(StatusEnum $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDescription(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setRecommendation(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setWeight(?float $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTemperature(?float $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setMeetResultId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setAdmissionTypeId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setPetId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setPetAlias(?string $value): static;

    /** Только дата без времени
     * @throws VetmanagerApiGatewayInnerException
     */
    public function setBirthdayFromString(?string $value): static;

    /** Только дата без времени
     * @throws VetmanagerApiGatewayInnerException
     */
    public function setBirthdayFromDateTime(DateTime $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setSexFromString(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setSexFromEnum(SexEnum $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setPetNote(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setPetTypeTitle(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setBreedTitle(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setClientId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setFirstName(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setLastName(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setMiddleName(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setOwnerPhone(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setUserLogin(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setUserFirstName(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setUserLastName(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setUserMiddleName(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setIsEditable(?bool $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setMeetResultTitle(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setAdmissionTypeTitle(?string $value): static;
}