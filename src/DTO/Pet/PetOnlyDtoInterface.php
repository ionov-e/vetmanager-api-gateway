<?php

namespace VetmanagerApiGateway\DTO\Pet;

use DateTime;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

interface PetOnlyDtoInterface
{
    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int;

    /** @return positive-int Ни в одной БД не нашел "null" или "0"
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getOwnerId(): int;

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getPetTypeId(): ?int;

    public function getAlias(): string;

    public function getSexAsString(): ?string;

    public function getSexAsEnum(): SexEnum;

    public function getDateRegisterAsString(): ?string;

    /**
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getDateRegisterAsDateTime(): ?DateTime;

    /** Дата без времени */
    public function getBirthdayAsString(): ?string;

    /** Дата без времени
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getBirthdayAsDateTime(): ?DateTime;

    public function getNote(): string;

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getBreedId(): ?int;

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getOldId(): ?int;

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getColorId(): ?int;

    public function getDeathNote(): string;

    public function getDeathDateAsString(): ?string;

    /** Default: ''. Самые разные строки прилетают */
    public function getChipNumber(): string;

    /** Default: ''. Самые разные строки прилетают */
    public function getLabNumber(): string;

    public function getStatusAsString(): ?string;

    public function getStatusAsEnum(): \VetmanagerApiGateway\DTO\Pet\StatusEnum;

    /** Datatype: longblob */
    public function getPicture(): string;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getWeight(): ?float;

    public function getEditDateAsString(): string;

    /** @throws VetmanagerApiGatewayResponseException */
    public function getEditDateAsDateTime(): DateTime;

    /** * @throws VetmanagerApiGatewayInnerException */
    public function setId(int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setOwnerId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTypeId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setAlias(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setSex(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDateRegisterAsString(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDateRegisterAsDateTime(DateTime $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setBirthdayAsString(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setBirthdayAsDateTime(DateTime $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setNote(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setBreedId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setOldId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setColorId(?int $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDeathNote(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDeathDateAsString(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setChipNumber(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setLabNumber(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setStatusAsString(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setStatusAsEnum(\VetmanagerApiGateway\DTO\Pet\StatusEnum $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setPicture(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setWeight(?float $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setEditDateAsString(?string $value): static;

    /** @throws VetmanagerApiGatewayInnerException */
    public function setEditDateAsDateTime(DateTime $value): static;
}