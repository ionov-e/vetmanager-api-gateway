<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DAO;

use Exception;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DAO\Interface\AllConstructorsInterface;
use VetmanagerApiGateway\DAO\Trait\AllConstructorsTrait;
use VetmanagerApiGateway\DTO;
use VetmanagerApiGateway\Enum\ApiRoute;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/**
 * @property-read ?City $ownerCity
 * @property-read ?Street $ownerStreet
 */
class Pet extends DTO\Pet implements AllConstructorsInterface
{
    use AllConstructorsTrait;

    /** Уже получен */
    public ?DTO\Client $client;
    /** Уже получен */
    public ?DTO\PetType $type;
    /** Уже получен */
    public ?Breed $breed;
    /** Уже получен */
    public ?DTO\ComboManualItem $color;
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
     * ?"owner": array{
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
     * ?"type": array{
     *      "id": string,
     *      "title": string,
     *      "picture": string,
     *      "type": ?string
     *      },
     * ?"breed": array{
     *      "id": string,
     *      "title": string,
     *      "pet_type_id": string
     *      },
     * ?"color": array{
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
     */
    protected readonly array $originalData;

    /** @throws VetmanagerApiGatewayException
     * @throws Exception
     */
    public function __construct(ApiGateway $api, array $originalData)
    {
        parent::__construct($api, $originalData);

        $this->client = $this->ownerId ? DTO\Client::fromDecodedJson($this->apiGateway, $this->originalData['owner']) : null;
        $this->type = $this->typeId ? DTO\PetType::fromDecodedJson($this->apiGateway, $this->originalData['type']) : null;
        $this->breed = $this->breedId ? Breed::fromDecodedJson($this->apiGateway, $this->getBreedApiData()) : null;
        $this->color = $this->colorId ? DTO\ComboManualItem::fromDecodedJson($this->apiGateway, $this->originalData['color']) : null;
    }

    private function getBreedApiData(): array
    {
        return array_merge(
            $this->originalData['breed'],
            ["petType" => $this->originalData['type']]
        );
    }

    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::Pet;
    }
}
