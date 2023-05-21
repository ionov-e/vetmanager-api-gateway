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
     * } $originalData
     * @throws VetmanagerApiGatewayException
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public static function fromApiResponseArray(array $originalData): self
    {
        $instance = new self();
        $instance->id = ApiInt::fromStringOrNull($originalData['id'])->positiveInt;
        $instance->ownerId = ApiInt::fromStringOrNull($originalData['owner_id'])->positiveInt;
        $instance->typeId = ApiInt::fromStringOrNull($originalData['type_id'])->positiveIntOrNull;
        $instance->alias = ApiString::fromStringOrNull($originalData['alias'])->string;
        $instance->sex = $originalData['sex'] ? Sex::from($originalData['sex']) : Sex::Unknown;
        $instance->dateRegister = ApiDateTime::fromOnlyDateString($originalData['date_register'])->dateTime;
        $instance->birthday = ApiDateTime::fromOnlyDateString($originalData['birthday'])->dateTimeOrNull;
        $instance->note = ApiString::fromStringOrNull($originalData['note'])->string;
        $instance->breedId = ApiInt::fromStringOrNull($originalData['breed_id'])->positiveIntOrNull;
        $instance->oldId = ApiInt::fromStringOrNull($originalData['old_id'])->positiveIntOrNull;
        $instance->colorId = ApiInt::fromStringOrNull($originalData['color_id'])->positiveIntOrNull;
        $instance->deathNote = ApiString::fromStringOrNull($originalData['deathnote'])->string;
        $instance->deathDate = ApiString::fromStringOrNull($originalData['deathdate'])->string;
        $instance->chipNumber = ApiString::fromStringOrNull($originalData['chip_number'])->string;
        $instance->labNumber = ApiString::fromStringOrNull($originalData['lab_number'])->string;
        $instance->status = Status::from($originalData['status']);
        $instance->picture = ApiString::fromStringOrNull($originalData['picture'])->string;
        $instance->weight = ApiFloat::fromStringOrNull($originalData['weight'])->nonZeroFloatOrNull;
        $instance->editDate = ApiDateTime::fromOnlyDateString($originalData['edit_date'])->dateTime;
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
