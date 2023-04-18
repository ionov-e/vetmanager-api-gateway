<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO\DTO;

use DateTime;
use Otis22\VetmanagerRestApi\Query\Builder;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\DateTimeContainer;
use VetmanagerApiGateway\DO\Enum\Pet\Sex;
use VetmanagerApiGateway\DO\Enum\Pet\Status;
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
    public int $id;
    /** Ни в одной БД не нашел "null" или "0" */
    public int $ownerId;
    public ?int $typeId;
    public string $alias;
    public Sex $sex;
    public DateTime $dateRegister;
    /** Дата без времени */
    public ?DateTime $birthday;
    public string $note;
    public ?int $breedId;
    public ?int $oldId;
    public ?int $colorId;
    public ?string $deathNote;
    public ?string $deathDate;
    /** Default: '' */
    public string $chipNumber;
    /** Default: '' */
    public string $labNumber;
    public Status $status;
    /** Datatype: longblob */
    public string $picture;
    public ?float $weight;
    public DateTime $editDate;
    /**
     * @var array{
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
     * } $originalData
     */
    protected readonly array $originalData;

    /** @throws VetmanagerApiGatewayException */
    public function __construct(ApiGateway $api, array $originalData)
    {
        parent::__construct($api, $originalData);

        $this->id = (int)$this->originalData['id'];
        $this->ownerId = (int)$this->originalData['owner_id'];
        $this->typeId = $this->originalData['type_id'] ? (int)$this->originalData['type_id'] : null;
        $this->alias = (string)$this->originalData['alias'];
        $this->sex = $this->originalData['sex'] ? Sex::from($this->originalData['sex']) : Sex::Unknown;
        $this->dateRegister = (DateTimeContainer::fromOnlyDateString($this->originalData['date_register']))->dateTime;
        $this->birthday = (DateTimeContainer::fromOnlyDateString($this->originalData['birthday']))->dateTimeOrNull;
        $this->note = (string)$this->originalData['note'];
        $this->breedId = $this->originalData['breed_id'] ? (int)$this->originalData['breed_id'] : null;
        $this->oldId = $this->originalData['old_id'] ? (int)$this->originalData['old_id'] : null;
        $this->colorId = $this->originalData['color_id'] ? (int)$this->originalData['color_id'] : null;
        $this->deathNote = $this->originalData['deathnote'] ? (string)$this->originalData['deathnote'] : null;
        $this->deathDate = $this->originalData['deathdate'] ? (string)$this->originalData['deathdate'] : null;
        $this->chipNumber = (string)$this->originalData['chip_number'];
        $this->labNumber = (string)$this->originalData['lab_number'];
        $this->status = Status::from($this->originalData['status']);
        $this->picture = (string)$this->originalData['picture'];
        $this->weight = $this->originalData['weight'] ? (float)$this->originalData['weight'] : null;
        $this->editDate = (DateTimeContainer::fromOnlyDateString($this->originalData['edit_date']))->dateTime;
    }

    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'self' => DAO\Pet::getById($this->apiGateway, $this->id),
            'breed' => $this->typeId ? DAO\Breed::getById($this->apiGateway, $this->breedId) : null,
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
