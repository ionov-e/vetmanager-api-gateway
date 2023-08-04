<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Pet;

use DateTime;
use VetmanagerApiGateway\ApiDataInterpreter\ToDateTime;
use VetmanagerApiGateway\ApiDataInterpreter\ToFloat;
use VetmanagerApiGateway\ApiDataInterpreter\ToInt;
use VetmanagerApiGateway\ApiDataInterpreter\ToString;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

class PetOnlyDto extends AbstractDTO
{
    public function __construct(
        protected ?string $id,
        protected ?string $owner_id,
        protected ?string $type_id,
        protected ?string $alias,
        protected ?string $sex,
        protected ?string $date_register,
        protected ?string $birthday,
        protected ?string $note,
        protected ?string $breed_id,
        protected ?string $old_id,
        protected ?string $color_id,
        protected ?string $deathnote,
        protected ?string $deathdate,
        protected ?string $chip_number,
        protected ?string $lab_number,
        protected ?string $status,
        protected ?string $picture,
        protected ?string $weight,
        protected ?string $edit_date
    ) {
    }

    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int
    {
        return ToInt::fromStringOrNull($this->id)->getPositiveInt();
    }

    /** @return positive-int Ни в одной БД не нашел "null" или "0"
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getOwnerId(): int
    {
        return ToInt::fromStringOrNull($this->owner_id)->getPositiveInt();
    }

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getTypeId(): ?int
    {
        return ToInt::fromStringOrNull($this->type_id)->getPositiveIntOrNull();
    }

    public function getAlias(): string
    {
        return ToString::fromStringOrNull($this->alias)->getStringEvenIfNullGiven();
    }

    public function getSexAsString(): ?string
    {
        return $this->sex;
    }

    public function getSexAsEnum(): SexEnum
    {
        return $this->sex ? SexEnum::from($this->sex) : SexEnum::Unknown;
    }

    public function getDateRegisterAsString(): ?string
    {
        return $this->date_register;
    }

    /**
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getDateRegisterAsDateTime(): DateTime
    {
        return ToDateTime::fromOnlyDateString($this->date_register)->getDateTimeOrThrow();
    }

    /** Дата без времени */
    public function getBirthdayAsString(): ?string
    {
        return $this->birthday;
    }

    /** Дата без времени */
    public function getBirthdayAsDateTime(): ?DateTime
    {
        return ToDateTime::fromOnlyDateString($this->birthday)->getDateTimeOrThrow();
    }

    public function getNote(): string
    {
        return ToString::fromStringOrNull($this->note)->getStringEvenIfNullGiven();
    }

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getBreedId(): ?int
    {
        return ToInt::fromStringOrNull($this->breed_id)->getPositiveIntOrNull();
    }

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getOldId(): ?int
    {
        return ToInt::fromStringOrNull($this->old_id)->getPositiveIntOrNull();
    }

    /** @return ?positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getColorId(): ?int
    {
        return ToInt::fromStringOrNull($this->color_id)->getPositiveIntOrNull();
    }

    public function getDeathNote(): string
    {
        return ToString::fromStringOrNull($this->deathnote)->getStringEvenIfNullGiven();
    }

    public function getDeathDateAsString(): ?string
    {
        return ToString::fromStringOrNull($this->deathdate)->getStringEvenIfNullGiven();
    }

    /** Default: ''. Самые разные строки прилетают */
    public function getChipNumber(): string
    {
        return ToString::fromStringOrNull($this->chip_number)->getStringEvenIfNullGiven();
    }

    /** Default: ''. Самые разные строки прилетают */
    public function getLabNumber(): string
    {
        return ToString::fromStringOrNull($this->lab_number)->getStringEvenIfNullGiven();
    }

    public function getStatusAsString(): ?string
    {
        return $this->status;
    }

    public function getStatusAsEnum(): \VetmanagerApiGateway\DTO\Pet\StatusEnum
    {
        return StatusEnum::from($this->status);
    }

    /** Datatype: longblob */
    public function getPicture(): string
    {
        return ToString::fromStringOrNull($this->picture)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayResponseException */
    public function getWeight(): ?float
    {
        return ToFloat::fromStringOrNull($this->weight)->getNonZeroFloatOrNull();
    }

    public function getEditDateAsString(): string
    {
        return $this->edit_date;
    }

    /** @throws VetmanagerApiGatewayResponseException */
    public function getEditDateAsDateTime(): DateTime
    {
        return ToDateTime::fromOnlyDateString($this->edit_date)->getDateTimeOrThrow();
    }

    /** * @throws VetmanagerApiGatewayInnerException */
    public function setId(int $value): static
    {
        return self::setPropertyFluently($this, 'id', (string)$value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setOwnerId(?int $value): static
    {
        return self::setPropertyFluently($this, 'owner_id', is_null($value) ? null : (string)$value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTypeId(?int $value): static
    {
        return self::setPropertyFluently($this, 'type_id', is_null($value) ? null : (string)$value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setAlias(?string $value): static
    {
        return self::setPropertyFluently($this, 'alias', $value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setSex(?string $value): static
    {
        return self::setPropertyFluently($this, 'sex', $value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDateRegister(?string $value): static
    {
        return self::setPropertyFluently($this, 'date_register', $value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setBirthday(?string $value): static
    {
        return self::setPropertyFluently($this, 'birthday', $value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setNote(?string $value): static
    {
        return self::setPropertyFluently($this, 'note', $value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setBreedId(?string $value): static
    {
        return self::setPropertyFluently($this, 'breed_id', $value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setOldId(?string $value): static
    {
        return self::setPropertyFluently($this, 'old_id', $value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setColorId(?string $value): static
    {
        return self::setPropertyFluently($this, 'color_id', $value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDeathnote(?string $value): static
    {
        return self::setPropertyFluently($this, 'deathnote', $value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDeathdate(?string $value): static
    {
        return self::setPropertyFluently($this, 'deathdate', $value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setChipNumber(?string $value): static
    {
        return self::setPropertyFluently($this, 'chip_number', $value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setLabNumber(?string $value): static
    {
        return self::setPropertyFluently($this, 'lab_number', $value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setStatus(?string $value): static
    {
        return self::setPropertyFluently($this, 'status', $value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setPicture(?string $value): static
    {
        return self::setPropertyFluently($this, 'picture', $value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setWeight(?string $value): static
    {
        return self::setPropertyFluently($this, 'weight', $value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setEditDate(?string $value): static
    {
        return self::setPropertyFluently($this, 'edit_date', $value);
    }

//    /**
//     * @param array{
//     *          id: numeric-string,
//     *          owner_id: ?numeric-string,
//     *          type_id: ?numeric-string,
//     *          alias: string,
//     *          sex: ?string,
//     *          date_register: string,
//     *          birthday: ?string,
//     *          note: string,
//     *          breed_id: ?numeric-string,
//     *          old_id: ?numeric-string,
//     *          color_id: ?numeric-string,
//     *          deathnote: ?string,
//     *          deathdate: ?string,
//     *          chip_number: string,
//     *          lab_number: string,
//     *          status: string,
//     *          picture: ?string,
//     *          weight: ?string,
//     *          edit_date: string,
//     *          owner?: array,
//     *          type?: array,
//     *          breed?: array,
//     *          color?: array
//     * } $originalDataArray
//     */
}
