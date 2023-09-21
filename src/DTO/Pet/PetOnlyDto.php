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
    /**
     * @param int|string|null $id
     * @param int|string|null $owner_id
     * @param int|string|null $type_id
     * @param string|null $alias
     * @param string|null $sex
     * @param string|null $date_register
     * @param string|null $birthday
     * @param string|null $note
     * @param int|string|null $breed_id
     * @param int|string|null $old_id
     * @param int|string|null $color_id
     * @param string|null $deathnote
     * @param string|null $deathdate
     * @param string|null $chip_number
     * @param string|null $lab_number
     * @param string|null $status
     * @param string|null $picture
     * @param string|null $weight
     * @param string|null $edit_date
     */
    public function __construct(
        protected int|string|null $id,
        protected int|string|null $owner_id,
        protected int|string|null $type_id,
        protected ?string         $alias,
        protected ?string         $sex,
        protected ?string         $date_register,
        protected ?string         $birthday,
        protected ?string         $note,
        protected int|string|null $breed_id,
        protected int|string|null $old_id,
        protected int|string|null $color_id,
        protected ?string         $deathnote,
        protected ?string         $deathdate,
        protected ?string         $chip_number,
        protected ?string         $lab_number,
        protected ?string         $status,
        protected ?string         $picture,
        protected ?string         $weight,
        protected ?string         $edit_date
    )
    {
    }

    public function getId(): int
    {
        return (ToInt::fromIntOrStringOrNull($this->id))->getPositiveIntOrThrow();
    }

    public function getOwnerId(): int
    {
        return (ToInt::fromIntOrStringOrNull($this->owner_id))->getPositiveIntOrThrow();
    }

    public function getPetTypeId(): ?int
    {
        return (ToInt::fromIntOrStringOrNull($this->type_id))->getPositiveIntOrNullOrThrowIfNegative();
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

    public function getDateRegisterAsDateTime(): ?DateTime
    {
        return ToDateTime::fromFullDateTimeString($this->date_register)->getDateTimeOrNull();
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
        return (ToInt::fromIntOrStringOrNull($this->breed_id))->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function getOldId(): ?int
    {
        return (ToInt::fromIntOrStringOrNull($this->old_id))->getPositiveIntOrNullOrThrowIfNegative();
    }

    public function getColorId(): ?int
    {
        return (ToInt::fromIntOrStringOrNull($this->color_id))->getPositiveIntOrNullOrThrowIfNegative();
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

    public function getStatusAsEnum(): StatusEnum
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
        return ToString::fromStringOrNull($this->edit_date)->getNonEmptyStringOrThrow();
    }

    public function getEditDateAsDateTime(): DateTime
    {
        return ToDateTime::fromOnlyDateString($this->edit_date)->getDateTimeOrThrow();
    }

    public function setOwnerId(?int $value): static
    {
        return self::setPropertyFluently($this, 'owner_id', $value);
    }

    public function setTypeId(?int $value): static
    {
        return self::setPropertyFluently($this, 'type_id', $value);
    }

    public function setAlias(?string $value): static
    {
        return self::setPropertyFluently($this, 'alias', $value);
    }

    public function setSex(?string $value): static
    {
        return self::setPropertyFluently($this, 'sex', $value);
    }

    public function setDateRegisterFromString(?string $value): static
    {
        return self::setPropertyFluently($this, 'date_register', $value);
    }

    public function setDateRegisterFromDateTime(DateTime $value): static
    {
        return self::setPropertyFluently($this, 'date_register', $value->format('Y-m-d H:i:s'));
    }

    public function setBirthdayFromString(?string $value): static
    {
        return self::setPropertyFluently($this, 'birthday', $value);
    }

    public function setBirthdayFromDateTime(DateTime $value): static
    {
        return self::setPropertyFluently($this, 'birthday', $value->format('Y-m-d H:i:s'));
    }

    public function setNote(?string $value): static
    {
        return self::setPropertyFluently($this, 'note', $value);
    }

    public function setBreedId(?int $value): static
    {
        return self::setPropertyFluently($this, 'breed_id', $value);
    }

    public function setOldId(?int $value): static
    {
        return self::setPropertyFluently($this, 'old_id', $value);
    }

    public function setColorId(?int $value): static
    {
        return self::setPropertyFluently($this, 'color_id', $value);
    }

    public function setDeathNote(?string $value): static
    {
        return self::setPropertyFluently($this, 'deathnote', $value);
    }

    public function setDeathDateFromString(?string $value): static
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

    public function setStatusFromString(?string $value): static
    {
        return self::setPropertyFluently($this, 'status', $value);
    }

    public function setStatusFromEnum(StatusEnum $value): static
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

    public function setEditDateFromString(?string $value): static
    {
        return self::setPropertyFluently($this, 'edit_date', $value);
    }

    public function setEditDateFromDateTime(DateTime $value): static
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
