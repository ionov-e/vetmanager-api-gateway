<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use DateTime;
use Exception;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO\DAO\ComboManualItem;
use VetmanagerApiGateway\DTO\Enum\Pet\Sex;
use VetmanagerApiGateway\DTO\Enum\Pet\Status;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/**
 * @property-read DAO\Pet $self
 * @property-read ?\VetmanagerApiGateway\DTO\DAO\Client $owner
 * @property-read ?\VetmanagerApiGateway\DTO\DAO\PetType $type
 * @property-read ?\VetmanagerApiGateway\DTO\DAO\Breed $breed
 * @property-read ?ComboManualItem $color
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

        try {
            $this->dateRegister = new DateTime($this->originalData['date_register']);
            $this->birthday = $this->originalData['birthday'] ? new DateTime($this->originalData['birthday']) : null;
            $this->editDate = new DateTime($this->originalData['edit_date']);
        } catch (Exception $e) {
            throw new VetmanagerApiGatewayException($e->getMessage());
        }
    }

    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'self' => DAO\Pet::getById($this->apiGateway, $this->id),
            'breed' => $this->typeId ? \VetmanagerApiGateway\DTO\DAO\Breed::getById($this->apiGateway, $this->breedId) : null,
            'color' => $this->colorId ? ComboManualItem::getById($this->apiGateway, $this->colorId) : null,
            'owner' => $this->ownerId ? \VetmanagerApiGateway\DTO\DAO\Client::getById($this->apiGateway, $this->ownerId) : null,
            'type' => $this->typeId ? \VetmanagerApiGateway\DTO\DAO\PetType::getById($this->apiGateway, $this->typeId) : null,
            default => $this->$name,
        };
    }
}
