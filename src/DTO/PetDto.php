<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use DateTime;
use VetmanagerApiGateway\DTO\Enum\Pet\Sex;
use VetmanagerApiGateway\DTO\Enum\Pet\Status;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Hydrator\ApiDateTime;
use VetmanagerApiGateway\Hydrator\ApiFloat;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;
use VetmanagerApiGateway\Hydrator\DtoPropertyList;

final class PetDto extends AbstractDTO
{
    /** @var positive-int */
    public int $id;
    /** @var positive-int Ни в одной БД не нашел "null" или "0" */
    public int $ownerId;
    /** @var ?positive-int */
    public ?int $typeId;
    public string $alias;
    public Sex $sex;
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
    public Status $status;
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
        $instance->id = ApiInt::fromStringOrNull($originalDataArray['id'])->getPositiveInt();
        $instance->ownerId = ApiInt::fromStringOrNull($originalDataArray['owner_id'])->getPositiveInt();
        $instance->typeId = ApiInt::fromStringOrNull($originalDataArray['type_id'])->getPositiveIntOrNull();
        $instance->alias = ApiString::fromStringOrNull($originalDataArray['alias'])->getStringEvenIfNullGiven();
        $instance->sex = $originalDataArray['sex'] ? Sex::from($originalDataArray['sex']) : Sex::Unknown;
        $instance->dateRegister = ApiDateTime::fromOnlyDateString($originalDataArray['date_register'])->getDateTimeOrThrow();
        $instance->birthday = ApiDateTime::fromOnlyDateString($originalDataArray['birthday'])->getDateTimeOrThrow();
        $instance->note = ApiString::fromStringOrNull($originalDataArray['note'])->getStringEvenIfNullGiven();
        $instance->breedId = ApiInt::fromStringOrNull($originalDataArray['breed_id'])->getPositiveIntOrNull();
        $instance->oldId = ApiInt::fromStringOrNull($originalDataArray['old_id'])->getPositiveIntOrNull();
        $instance->colorId = ApiInt::fromStringOrNull($originalDataArray['color_id'])->getPositiveIntOrNull();
        $instance->deathNote = ApiString::fromStringOrNull($originalDataArray['deathnote'])->getStringEvenIfNullGiven();
        $instance->deathDate = ApiString::fromStringOrNull($originalDataArray['deathdate'])->getStringEvenIfNullGiven();
        $instance->chipNumber = ApiString::fromStringOrNull($originalDataArray['chip_number'])->getStringEvenIfNullGiven();
        $instance->labNumber = ApiString::fromStringOrNull($originalDataArray['lab_number'])->getStringEvenIfNullGiven();
        $instance->status = Status::from($originalDataArray['status']);
        $instance->picture = ApiString::fromStringOrNull($originalDataArray['picture'])->getStringEvenIfNullGiven();
        $instance->weight = ApiFloat::fromStringOrNull($originalDataArray['weight'])->getNonZeroFloatOrNull();
        $instance->editDate = ApiDateTime::fromOnlyDateString($originalDataArray['edit_date'])->getDateTimeOrThrow();
        return $instance;
    }


    /** @inheritdoc */
    public function getRequiredKeysForPostArray(): array #TODO No Idea
    {
        return [];
    }


    /** @inheritdoc
     * @throws VetmanagerApiGatewayRequestException
     */
    protected function getSetValuesWithoutId(): array
    {
        return (new DtoPropertyList(
            $this,
            ['ownerId', 'owner_id'],
            ['typeId', 'type_id'],
            ['alias', 'alias'],
            ['sex', 'sex'],
            ['dateRegister', 'date_register'],
            ['birthday', 'birthday'],
            ['note', 'note'],
            ['breedId', 'breed_id'],
            ['oldId', 'old_id'],
            ['colorId', 'color_id'],
            ['deathNote', 'deathnote'],
            ['deathDate', 'deathdate'],
            ['chipNumber', 'chip_number'],
            ['labNumber', 'lab_number'],
            ['status', 'status'],
            ['picture', 'picture'],
            ['weight', 'weight'],
            ['editDate', 'edit_date'],
        ))->toArray();
    }

}
