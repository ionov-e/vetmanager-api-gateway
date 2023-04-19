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
 * @property-read ?DAO\MedicalCard[] medicalCards
 * @property-read ?DAO\MedicalCardAsVaccination[] vaccines
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
    public function __construct(ApiGateway $api, array $originalData)
    {
        parent::__construct($api, $originalData);

        $this->id = IntContainer::fromStringOrNull($this->originalData['id'])->positiveInt;
        $this->ownerId = IntContainer::fromStringOrNull($this->originalData['owner_id'])->positiveInt;
        $this->typeId = IntContainer::fromStringOrNull($this->originalData['type_id'])->positiveIntOrNull;
        $this->alias = StringContainer::fromStringOrNull($this->originalData['alias'])->string;
        $this->sex = $this->originalData['sex'] ? Sex::from($this->originalData['sex']) : Sex::Unknown;
        $this->dateRegister = DateTimeContainer::fromOnlyDateString($this->originalData['date_register'])->dateTime;
        $this->birthday = DateTimeContainer::fromOnlyDateString($this->originalData['birthday'])->dateTimeOrNull;
        $this->note = StringContainer::fromStringOrNull($this->originalData['note'])->string;
        $this->breedId = IntContainer::fromStringOrNull($this->originalData['breed_id'])->positiveIntOrNull;
        $this->oldId = IntContainer::fromStringOrNull($this->originalData['old_id'])->positiveIntOrNull;
        $this->colorId = IntContainer::fromStringOrNull($this->originalData['color_id'])->positiveIntOrNull;
        $this->deathNote = StringContainer::fromStringOrNull($this->originalData['deathnote'])->string;
        $this->deathDate = StringContainer::fromStringOrNull($this->originalData['deathdate'])->string;
        $this->chipNumber = StringContainer::fromStringOrNull($this->originalData['chip_number'])->string;
        $this->labNumber = StringContainer::fromStringOrNull($this->originalData['lab_number'])->string;
        $this->status = Status::from($this->originalData['status']);
        $this->picture = StringContainer::fromStringOrNull($this->originalData['picture'])->string;
        $this->weight = FloatContainer::fromStringOrNull($this->originalData['weight'])->nonZeroFloatOrNull;
        $this->editDate = DateTimeContainer::fromOnlyDateString($this->originalData['edit_date'])->dateTime;
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
            'medicalCards' => DAO\MedicalCard::getByPagedQuery(
                $this->apiGateway,
                (new Builder())->where('patient_id', (string)$this->id)->paginateAll()
            ),
            'vaccines' => DAO\MedicalCardAsVaccination::getByPetId($this->apiGateway, $this->id),
            default => $this->$name,
        };
    }
}
