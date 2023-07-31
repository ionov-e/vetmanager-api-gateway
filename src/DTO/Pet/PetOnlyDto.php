<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Pet;

use DateTime;
use VetmanagerApiGateway\ApiDataInterpreter\ToDateTime;
use VetmanagerApiGateway\ApiDataInterpreter\ToFloat;
use VetmanagerApiGateway\ApiDataInterpreter\ToInt;
use VetmanagerApiGateway\ApiDataInterpreter\ToString;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class PetOnlyDto extends AbstractDTO
{
    /** @var positive-int */
    public int $id;
    /** @var positive-int Ни в одной БД не нашел "null" или "0" */
    public int $ownerId;
    /** @var ?positive-int */
    public ?int $typeId;
    public string $alias;
    public SexEnum $sex;
    public DateTime $dateRegister;
    /** Дата без времени */
    public ?DateTime $birthday;
    public string $note;
    /** @var ?positive-int */
    public ?int $breedId;
    /** @var ?positive-int */
    public ?int $oldId;
    /** @var ?positive-int */
    public ?int $colorId;
    public string $deathNote;
    public string $deathDate;
    /** Default: ''. Самые разные строки прилетают */
    public string $chipNumber;
    /** Default: ''. Самые разные строки прилетают */
    public string $labNumber;
    public StatusEnum $status;
    /** Datatype: longblob */
    public string $picture;
    public ?float $weight;
    public DateTime $editDate;

    /**
     * @param array{
     *          id: numeric-string,
     *          owner_id: ?numeric-string,
     *          type_id: ?numeric-string,
     *          alias: string,
     *          sex: ?string,
     *          date_register: string,
     *          birthday: ?string,
     *          note: string,
     *          breed_id: ?numeric-string,
     *          old_id: ?numeric-string,
     *          color_id: ?numeric-string,
     *          deathnote: ?string,
     *          deathdate: ?string,
     *          chip_number: string,
     *          lab_number: string,
     *          status: string,
     *          picture: ?string,
     *          weight: ?string,
     *          edit_date: string,
     *          owner?: array,
     *          type?: array,
     *          breed?: array,
     *          color?: array
     * } $originalDataArray
     * @throws VetmanagerApiGatewayException
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public static function fromApiResponseArray(array $originalDataArray): self
    {
        $instance = new self($originalDataArray);
        $instance->id = ToInt::fromStringOrNull($originalDataArray['id'])->getPositiveInt();
        $instance->ownerId = ToInt::fromStringOrNull($originalDataArray['owner_id'])->getPositiveInt();
        $instance->typeId = ToInt::fromStringOrNull($originalDataArray['type_id'])->getPositiveIntOrNull();
        $instance->alias = ToString::fromStringOrNull($originalDataArray['alias'])->getStringEvenIfNullGiven();
        $instance->sex = $originalDataArray['sex'] ? SexEnum::from($originalDataArray['sex']) : SexEnum::Unknown;
        $instance->dateRegister = ToDateTime::fromOnlyDateString($originalDataArray['date_register'])->getDateTimeOrThrow();
        $instance->birthday = ToDateTime::fromOnlyDateString($originalDataArray['birthday'])->getDateTimeOrThrow();
        $instance->note = ToString::fromStringOrNull($originalDataArray['note'])->getStringEvenIfNullGiven();
        $instance->breedId = ToInt::fromStringOrNull($originalDataArray['breed_id'])->getPositiveIntOrNull();
        $instance->oldId = ToInt::fromStringOrNull($originalDataArray['old_id'])->getPositiveIntOrNull();
        $instance->colorId = ToInt::fromStringOrNull($originalDataArray['color_id'])->getPositiveIntOrNull();
        $instance->deathNote = ToString::fromStringOrNull($originalDataArray['deathnote'])->getStringEvenIfNullGiven();
        $instance->deathDate = ToString::fromStringOrNull($originalDataArray['deathdate'])->getStringEvenIfNullGiven();
        $instance->chipNumber = ToString::fromStringOrNull($originalDataArray['chip_number'])->getStringEvenIfNullGiven();
        $instance->labNumber = ToString::fromStringOrNull($originalDataArray['lab_number'])->getStringEvenIfNullGiven();
        $instance->status = StatusEnum::from($originalDataArray['status']);
        $instance->picture = ToString::fromStringOrNull($originalDataArray['picture'])->getStringEvenIfNullGiven();
        $instance->weight = ToFloat::fromStringOrNull($originalDataArray['weight'])->getNonZeroFloatOrNull();
        $instance->editDate = ToDateTime::fromOnlyDateString($originalDataArray['edit_date'])->getDateTimeOrThrow();
        return $instance;
    }
}
