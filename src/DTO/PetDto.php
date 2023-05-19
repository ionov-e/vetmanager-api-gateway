<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use DateTime;
use VetmanagerApiGateway\Hydrator\ApiDateTime;
use VetmanagerApiGateway\Hydrator\ApiFloat;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;
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
        $this->id = ApiInt::fromStringOrNull($originalData['id'])->positiveInt;
        $this->ownerId = ApiInt::fromStringOrNull($originalData['owner_id'])->positiveInt;
        $this->typeId = ApiInt::fromStringOrNull($originalData['type_id'])->positiveIntOrNull;
        $this->alias = ApiString::fromStringOrNull($originalData['alias'])->string;
        $this->sex = $originalData['sex'] ? Sex::from($originalData['sex']) : Sex::Unknown;
        $this->dateRegister = ApiDateTime::fromOnlyDateString($originalData['date_register'])->dateTime;
        $this->birthday = ApiDateTime::fromOnlyDateString($originalData['birthday'])->dateTimeOrNull;
        $this->note = ApiString::fromStringOrNull($originalData['note'])->string;
        $this->breedId = ApiInt::fromStringOrNull($originalData['breed_id'])->positiveIntOrNull;
        $this->oldId = ApiInt::fromStringOrNull($originalData['old_id'])->positiveIntOrNull;
        $this->colorId = ApiInt::fromStringOrNull($originalData['color_id'])->positiveIntOrNull;
        $this->deathNote = ApiString::fromStringOrNull($originalData['deathnote'])->string;
        $this->deathDate = ApiString::fromStringOrNull($originalData['deathdate'])->string;
        $this->chipNumber = ApiString::fromStringOrNull($originalData['chip_number'])->string;
        $this->labNumber = ApiString::fromStringOrNull($originalData['lab_number'])->string;
        $this->status = Status::from($originalData['status']);
        $this->picture = ApiString::fromStringOrNull($originalData['picture'])->string;
        $this->weight = ApiFloat::fromStringOrNull($originalData['weight'])->nonZeroFloatOrNull;
        $this->editDate = ApiDateTime::fromOnlyDateString($originalData['edit_date'])->dateTime;
    }
}
