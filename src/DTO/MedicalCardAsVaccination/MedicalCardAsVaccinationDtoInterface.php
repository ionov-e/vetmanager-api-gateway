<?php

namespace VetmanagerApiGateway\DTO\MedicalCardAsVaccination;

use DateTime;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

interface MedicalCardAsVaccinationDtoInterface
{
    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int;

    public function getName(): string;

    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getPetId(): int;

    public function getDateAsString(): ?string;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getDateAsDateTime(): ?DateTime;

    public function getDateNextDateTimeAsString(): ?string;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getDateNextDateTimeAsDateTime(): ?DateTime;

    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getGoodId(): int;

    public function getBirthdayAsString(): ?string;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getBirthdayAsDateTime(): ?DateTime;

    /** Игнорируем. Бред присылается */
    public function getBirthdayAtTime(): ?string;

    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getMedicalCardId(): int;

    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getDoseTypeId(): int;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getDoseValue(): ?string;

    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getSaleParamId(): int;

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getVaccineTypeId(): ?int;

    public function getVaccineDescription(): ?string;

    public function getVaccineTypeTitle(): ?string;

    /** @return ?positive-int
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