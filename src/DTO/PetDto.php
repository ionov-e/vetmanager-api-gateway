<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use DateTime;
use VetmanagerApiGateway\DO\DateTimeContainer;
use VetmanagerApiGateway\DO\FloatContainer;
use VetmanagerApiGateway\DO\IntContainer;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\DTO\Enum\Pet\Sex;
use VetmanagerApiGateway\DTO\Enum\Pet\Status;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/**
 * @property-read ?DAO\Client owner
 * @property-read ?DAO\PetType type
 * @property-read ?DAO\Breed breed
 * @property-read ?DAO\ComboManualItem $color
 * @property-read DAO\MedicalCard[] medicalCards
 * @property-read DAO\MedicalCardAsVaccination[] vaccines
 * @property-read DAO\Admission[] admissions
 * @property-read DAO\Admission[] admissionsOfOwner
 */
class PetDto extends AbstractDTO
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
     * "id": string,
     * "owner_id": ?string,
     * "type_id": ?string,
     * "alias": string,
     * "sex": ?string,
     * "date_register": string,
     * "birthday": ?string,
     * "note": string,
     * "breed_id": ?string,
     * "old_id": ?string,
     * "color_id": ?string,
     * "deathnote": ?string,
     * "deathdate": ?string,
     * "chip_number": string,
     * "lab_number": string,
     * "status": string,
     * "picture": ?string,
     * "weight": ?string,
     * "edit_date": string,
     * "owner"?: array,
     * "type"?: array,
     * "breed"?: array,
     * "color"?: array
     * } $originalData
     * @throws VetmanagerApiGatewayException
     */
    public function __construct(array $originalData)
    {
        $this->id = IntContainer::fromStringOrNull($originalData['id'])->positiveInt;
        $this->ownerId = IntContainer::fromStringOrNull($originalData['owner_id'])->positiveInt;
        $this->typeId = IntContainer::fromStringOrNull($originalData['type_id'])->positiveIntOrNull;
        $this->alias = StringContainer::fromStringOrNull($originalData['alias'])->string;
        $this->sex = $originalData['sex'] ? Sex::from($originalData['sex']) : Sex::Unknown;
        $this->dateRegister = DateTimeContainer::fromOnlyDateString($originalData['date_register'])->dateTime;
        $this->birthday = DateTimeContainer::fromOnlyDateString($originalData['birthday'])->dateTimeOrNull;
        $this->note = StringContainer::fromStringOrNull($originalData['note'])->string;
        $this->breedId = IntContainer::fromStringOrNull($originalData['breed_id'])->positiveIntOrNull;
        $this->oldId = IntContainer::fromStringOrNull($originalData['old_id'])->positiveIntOrNull;
        $this->colorId = IntContainer::fromStringOrNull($originalData['color_id'])->positiveIntOrNull;
        $this->deathNote = StringContainer::fromStringOrNull($originalData['deathnote'])->string;
        $this->deathDate = StringContainer::fromStringOrNull($originalData['deathdate'])->string;
        $this->chipNumber = StringContainer::fromStringOrNull($originalData['chip_number'])->string;
        $this->labNumber = StringContainer::fromStringOrNull($originalData['lab_number'])->string;
        $this->status = Status::from($originalData['status']);
        $this->picture = StringContainer::fromStringOrNull($originalData['picture'])->string;
        $this->weight = FloatContainer::fromStringOrNull($originalData['weight'])->nonZeroFloatOrNull;
        $this->editDate = DateTimeContainer::fromOnlyDateString($originalData['edit_date'])->dateTime;
    }
}
