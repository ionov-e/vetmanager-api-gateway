<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use Otis22\VetmanagerRestApi\Query\Builder;
use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Interface\RequestPostInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\ActiveRecord\Trait\RequestPostTrait;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/**
 * @property-read ?City $ownerCity
 * @property-read ?Street $ownerStreet
 */
final class Pet extends AbstractActiveRecord implements AllGetRequestsInterface, RequestPostInterface
{

    use AllGetRequestsTrait;
    use RequestPostTrait;

    /** Уже получен */
    public ?Client $client;
    /** Уже получен */
    public ?PetType $type;
    /** Уже получен */
    public ?Breed $breed;
    /** Уже получен */
    public ?ComboManualItem $color;

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
     * "owner"?: array{
     *      "id": string,
     *      "address": string,
     *      "home_phone": string,
     *      "work_phone": string,
     *      "note": string,
     *      "type_id": ?string,
     *      "how_find": ?string,
     *      "balance": string,
     *      "email": string,
     *      "city": string,
     *      "city_id": ?string,
     *      "date_register": string,
     *      "cell_phone": string,
     *      "zip": string,
     *      "registration_index": ?string,
     *      "vip": string,
     *      "last_name": string,
     *      "first_name": string,
     *      "middle_name": string,
     *      "status": string,
     *      "discount": string,
     *      "passport_series": string,
     *      "lab_number": string,
     *      "street_id": string,
     *      "apartment": string,
     *      "unsubscribe": string,
     *      "in_blacklist": string,
     *      "last_visit_date": string,
     *      "number_of_journal": string,
     *      "phone_prefix": ?string
     *      },
     * "type"?: array{
     *      "id": string,
     *      "title": string,
     *      "picture": string,
     *      "type": ?string
     *      },
     * "breed"?: array{
     *      "id": string,
     *      "title": string,
     *      "pet_type_id": string
     *      },
     * "color"?: array{
     *      "id": string,
     *      "combo_manual_id": string,
     *      "title": string,
     *      "value": string,
     *      "dop_param1": string,
     *      "dop_param2": string,
     *      "dop_param3": string,
     *      "is_active": string
     *      }
     * } $originalData
     * @throws VetmanagerApiGatewayException
     */
    public function __construct(ApiGateway $api, array $originalData)
    {
        parent::__construct($api, $originalData);

        $this->client = !empty($originalData['owner']) ? ClientDto::fromSingleObjectContents($this->apiGateway, $originalData['owner']) : null;
        $this->type = !empty($originalData['type']) ? PetTypeDto::fromSingleObjectContents($this->apiGateway, $originalData['type']) : null;
        $this->breed = !empty($originalData['breed']) ? Breed::fromSingleDtoArray($this->apiGateway, $this->getDataForBreedActiveRecord()) : null;
        $this->color = !empty($originalData['color']) ? ComboManualItemDto::fromSingleObjectContents($this->apiGateway, $originalData['color']) : null;
    }

    private function getDataForBreedActiveRecord(): array
    {
        return array_merge(
            $this->originalDataArray['breed'],
            ["petType" => $this->originalDataArray['type']]
        );
    }

    /** @return ApiModel::Pet */
    public static function getApiModel(): ApiModel
    {
        return ApiModel::Pet;
    }

    /** @throws VetmanagerApiGatewayException
     * @psalm-suppress DocblockTypeContradiction
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'breed' => $this->breedId ? Breed::getById($this->apiGateway, $this->breedId) : null,
            'color' => $this->colorId ? ComboManualItem::getByPetColorId($this->apiGateway, $this->colorId) : null,
            'owner' => $this->ownerId ? Client::getById($this->apiGateway, $this->ownerId) : null,
            'type' => $this->typeId ? PetType::getById($this->apiGateway, $this->typeId) : null,
            'admissions' => Admission::getByPetId($this->apiGateway, $this->id),
            'admissionsOfOwner' => Admission::getByClientId($this->apiGateway, $this->ownerId),
            'medicalCards' => MedicalCard::getByPagedQuery(
                $this->apiGateway,
                (new Builder())->where('patient_id', (string)$this->id)->paginateAll()
            ),
            'vaccines' => MedicalCardAsVaccination::getByPetId($this->apiGateway, $this->id),
            default => $this->originalDto->$name,
        };
    }
}
