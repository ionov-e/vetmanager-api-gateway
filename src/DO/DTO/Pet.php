<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO\DTO;

use DateTime;
use Otis22\VetmanagerRestApi\Query\Builder;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\DateTimeContainer;
use VetmanagerApiGateway\DO\Enum\Pet\Sex;
use VetmanagerApiGateway\DO\Enum\Pet\Status;
use VetmanagerApiGateway\DO\FloatContainer;
use VetmanagerApiGateway\DO\IntContainer;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/**
 * @property-read DAO\Pet self
 * @property-read ?DAO\Client owner
 * @property-read ?DAO\PetType type
 * @property-read ?DAO\Breed breed
 * @property-read ?DAO\ComboManualItem $color
 * @property-read DAO\MedicalCard[] medicalCards
 * @property-read DAO\MedicalCardAsVaccination[] vaccines
 * @property-read DAO\AdmissionFromGetAll[] admissions
 * @property-read DAO\AdmissionFromGetAll[] admissionsOfOwner
 */
class Pet extends AbstractDTO
{
    /** @var positive-int */
    public int $id;
    /** @var positive-int Ни в одной БД не нашел "null" или "0" */
    public int $ownerId;
    /** @var ?positive-int */
    public ?int $typeId;
    public string $alias;
    public Sex $sex;
    public ?DateTime $dateRegister;
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
    public function __construct(ApiGateway $api, array $originalData)
    {
        parent::__construct($api, $originalData);

        $this->id = IntContainer::fromStringOrNull($originalData['id'])->positiveInt;
        $this->ownerId = IntContainer::fromStringOrNull($originalData['owner_id'])->positiveInt;
        $this->typeId = IntContainer::fromStringOrNull($originalData['type_id'])->positiveIntOrNull;
        $this->alias = StringContainer::fromStringOrNull($originalData['alias'])->string;
        $this->sex = $originalData['sex'] ? Sex::from($originalData['sex']) : Sex::Unknown;
        $this->dateRegister = DateTimeContainer::fromOnlyDateString($originalData['date_register'])->dateTimeOrNull;
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

    /** @throws VetmanagerApiGatewayException
     * @psalm-suppress DocblockTypeContradiction
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'self' => DAO\Pet::getById($this->apiGateway, $this->id),
            'breed' => $this->breedId ? DAO\Breed::getById($this->apiGateway, $this->breedId) : null,
            'color' => $this->colorId ? DAO\ComboManualItem::getByPetColorId($this->apiGateway, $this->colorId) : null,
            'owner' => $this->ownerId ? DAO\Client::getById($this->apiGateway, $this->ownerId) : null,
            'type' => $this->typeId ? DAO\PetType::getById($this->apiGateway, $this->typeId) : null,
            'admissions' => DAO\AdmissionFromGetAll::getByPetId($this->apiGateway, $this->id),
            'admissionsOfOwner' => DAO\AdmissionFromGetAll::getByClientId($this->apiGateway, $this->ownerId),
            'medicalCards' => DAO\MedicalCard::getByPagedQuery(
                $this->apiGateway,
                (new Builder())->where('patient_id', (string)$this->id)->paginateAll()
            ),
            'vaccines' => DAO\MedicalCardAsVaccination::getByPetId($this->apiGateway, $this->id),
            default => $this->$name,
        };
    }
}
