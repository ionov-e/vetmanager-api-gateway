<?php

namespace VetmanagerApiGateway\DTO\MedicalCardAsVaccination;

use DateTime;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

interface MedicalCardAsVaccinationDtoInterface
{
    /** @return positive-int id из таблицы vaccine_pets
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int;

    /** title из таблицы vaccine_pets */
    public function getName(): string;

    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getPetId(): int;

    /** Дата без времени. Пример: "2012-09-02 00:00:00", а может прийти, если ничего: "0000-00-00". Из таблицы vaccine_pets*/
    public function getDateAsString(): ?string;

    /** Дата без времени. Пример: "2012-09-02 00:00:00", а может прийти, если ничего: "0000-00-00". Из таблицы vaccine_pets
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getDateAsDateTime(): ?DateTime;

    public function getDateNextDateTimeAsString(): ?string;

    /** Может содержать в себе:
     * 1) Лишь дату
     * 2) Дату со временем
     * 3) Null
     * Значение берется из admission_date из таблицы admission ON admission.id = vaccine_pets.next_admission_id.
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getDateNextDateTimeAsDateTime(): ?DateTime;

    /** @return ?positive-int Точно редко бывает null
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getGoodId(): ?int;

    /** Дата без времени. Пример: "2012-09-02 00:00:00". Может быть и null */
    public function getBirthdayAsString(): ?string;

    /** Дата без времени
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getBirthdayAsDateTime(): ?DateTime;

    /** Игнорируем. Бред присылается */
    public function getBirthdayAtTime(): ?string;

    /** @return positive-int Default in DB: "0". Но не видел нигде 0 - не предусматриваю
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getMedicalCardId(): int;

    /** @return positive-int Default in DB: "0". Но не видел нигде 0 - не предусматриваю
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getDoseTypeId(): int;

    /** Default: "1.0000000000". Из таблицы vaccine_pets
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getDoseValue(): ?float;

    /** @return positive-int Из таблицы vaccine_pets. Но не видел нигде 0 - не предусматриваю
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getSaleParamId(): int;

    /** @return ?positive-int Default: "0" - перевожу в null
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getVaccineTypeId(): ?int;

    /** Default: "". Из таблицы vaccine_pets */
    public function getVaccineDescription(): ?string;

    /** Default: "". Title из таблицы combo_manual_items (строка, где: value = {@see $vaccineType} & combo_manual_id = $comboManualIdOfVaccinationType*/
    public function getVaccineTypeTitle(): string;

    /** @return ?positive-int Default in DB: "0". Перевожу в null. Из таблицы vaccine_pets
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getNextAdmissionId(): ?int;

    /** Еще не увидел пример в каком виде присылается */
    public function getNextVisitTimeAsString(): ?string;

    /** Игнорируем. Бред присылается в виде: "7л. 10м. 1д." (не помню какие - но есть ошибки в логике) */
    public function getPetAgeAtTimeVaccinationAsString(): ?string;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setName(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setPetId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDateAsString(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDateAsDateTime(DateTime $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDateNextDateTime(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setGoodId(?int $value): static;

    /** Без времени. Пример: '2020-10-10'
     * @throws VetmanagerApiGatewayInnerException
     */
    public function setBirthdayAsString(?string $value): static;

    /** Без времени
     * @throws VetmanagerApiGatewayInnerException
     */
    public function setBirthdayAsDateTime(DateTime $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setMedicalCardId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDoseTypeId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDoseValue(?float $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setSaleParamId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setVaccineTypeId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setVaccineDescription(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setVaccineTypeTitle(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setNextAdmissionId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setNextVisitTimeAsString(?string $value): static;
}