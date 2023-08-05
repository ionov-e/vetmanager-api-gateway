<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Pet;

use DateTime;
use VetmanagerApiGateway\ApiDataInterpreter\ToDateTime;
use VetmanagerApiGateway\ApiDataInterpreter\ToFloat;
use VetmanagerApiGateway\ApiDataInterpreter\ToInt;
use VetmanagerApiGateway\ApiDataInterpreter\ToString;
use VetmanagerApiGateway\DTO\AbstractDTO;

class PetOnlyDto extends AbstractDTO implements PetOnlyDtoInterface
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
    )
    {
    }

    public function getId(): int
    {
        return ToInt::fromStringOrNull($this->id)->getPositiveInt();
    }

    public function getOwnerId(): int
    {
        return ToInt::fromStringOrNull($this->owner_id)->getPositiveInt();
    }

    public function getPetTypeId(): ?int
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

    public function getDateRegisterAsDateTime(): DateTime
    {
        return ToDateTime::fromOnlyDateString($this->date_register)->getDateTimeOrThrow();
    }

    public function getBirthdayAsString(): ?string
    {
        return $this->birthday;
    }

    public function getBirthdayAsDateTime(): ?DateTime
    {
        return ToDateTime::fromOnlyDateString($this->birthday)->getDateTimeOrThrow();
    }

    public function getNote(): string
    {
        return ToString::fromStringOrNull($this->note)->getStringEvenIfNullGiven();
    }

    public function getBreedId(): ?int
    {
        return ToInt::fromStringOrNull($this->breed_id)->getPositiveIntOrNull();
    }

    public function getOldId(): ?int
    {
        return ToInt::fromStringOrNull($this->old_id)->getPositiveIntOrNull();
    }

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

    public function getChipNumber(): string
    {
        return ToString::fromStringOrNull($this->chip_number)->getStringEvenIfNullGiven();
    }

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

    public function getPicture(): string
    {
        return ToString::fromStringOrNull($this->picture)->getStringEvenIfNullGiven();
    }

    public function getWeight(): ?float
    {
        return ToFloat::fromStringOrNull($this->weight)->getNonZeroFloatOrNull();
    }

    public function getEditDateAsString(): string
    {
        return $this->edit_date;
    }

    public function getEditDateAsDateTime(): DateTime
    {
        return ToDateTime::fromOnlyDateString($this->edit_date)->getDateTimeOrThrow();
    }

    public function setId(int $value): static
    {
        return self::setPropertyFluently($this, 'id', (string)$value);
    }

    public function setOwnerId(?int $value): static
    {
        return self::setPropertyFluently($this, 'owner_id', is_null($value) ? null : (string)$value);
    }

    public function setTypeId(?int $value): static
    {
        return self::setPropertyFluently($this, 'type_id', is_null($value) ? null : (string)$value);
    }

    public function setAlias(?string $value): static
    {
        return self::setPropertyFluently($this, 'alias', $value);
    }

    public function setSex(?string $value): static
    {
        return self::setPropertyFluently($this, 'sex', $value);
    }

    public function setDateRegisterAsString(?string $value): static
    {
        return self::setPropertyFluently($this, 'date_register', $value);
    }

    public function setDateRegisterAsDateTime(DateTime $value): static
    {
        return self::setPropertyFluently($this, 'date_register', $value->format('Y-m-d H:i:s'));
    }

    public function setBirthdayAsString(?string $value): static
    {
        return self::setPropertyFluently($this, 'birthday', $value);
    }

    public function setBirthdayAsDateTime(DateTime $value): static
    {
        return self::setPropertyFluently($this, 'birthday', $value->format('Y-m-d H:i:s'));
    }

    public function setNote(?string $value): static
    {
        return self::setPropertyFluently($this, 'note', $value);
    }

    public function setBreedId(?int $value): static
    {
        return self::setPropertyFluently($this, 'breed_id', is_null($value) ? null : (string)$value);
    }

    public function setOldId(?int $value): static
    {
        return self::setPropertyFluently($this, 'old_id', is_null($value) ? null : (string)$value);
    }

    public function setColorId(?int $value): static
    {
        return self::setPropertyFluently($this, 'color_id', is_null($value) ? null : (string)$value);
    }

    public function setDeathNote(?string $value): static
    {
        return self::setPropertyFluently($this, 'deathnote', $value);
    }

    public function setDeathDateAsString(?string $value): static
    {
        return self::setPropertyFluently($this, 'deathdate', $value);
    }

    public function setChipNumber(?string $value): static
    {
        return self::setPropertyFluently($this, 'chip_number', $value);
    }

    public function setLabNumber(?string $value): static
    {
        return self::setPropertyFluently($this, 'lab_number', $value);
    }

    public function setStatusAsString(?string $value): static
    {
        return self::setPropertyFluently($this, 'status', $value);
    }

    public function setStatusAsEnum(\VetmanagerApiGateway\DTO\Pet\StatusEnum $value): static
    {
        return self::setPropertyFluently($this, 'status', $value->value);
    }

    public function setPicture(?string $value): static
    {
        return self::setPropertyFluently($this, 'picture', $value);
    }

    public function setWeight(?float $value): static
    {
        return self::setPropertyFluently($this, 'weight', is_null($value) ? null : (string)$value);
    }

    public function setEditDateAsString(?string $value): static
    {
        return self::setPropertyFluently($this, 'edit_date', $value);
    }

    public function setEditDateAsDateTime(DateTime $value): static
    {
        return self::setPropertyFluently($this, 'edit_date', $value->format('Y-m-d H:i:s'));
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
