<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO\DTO\DAO;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\DTO\AbstractDTO;
use VetmanagerApiGateway\DO\DTO\DAO;
use VetmanagerApiGateway\DO\DTO\DAO\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\DO\DTO\DAO\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\DO\DTO\DAO\Trait\BasicDAOTrait;
use VetmanagerApiGateway\DO\Enum\ApiRoute;
use VetmanagerApiGateway\DO\Enum\Street\Type;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/**
 * @property-read CityType $cityType
 */
class Street extends AbstractDTO implements AllGetRequestsInterface
{
    use BasicDAOTrait, AllGetRequestsTrait;

    public int $id;
    /** Default: '' */
    public string $title;
    /** Default: 'street'*/
    public Type $type;
    /** Default: 0 */
    public int $cityId;
    public ?City $city;

    /** @var array{
     *     "id": string,
     *     "title": string,
     *     "city_id": string,
     *     "type": string,
     *     ?"city": array{
     *              "id": string,
     *              "title": ?string,
     *              "type_id": ?string
     *     }
     * } $originalData
     */
    protected readonly array $originalData;

    /** @throws VetmanagerApiGatewayException */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = (int)$this->originalData['id'];
        $this->title = (string)$this->originalData['title'];
        $this->cityId = (int)$this->originalData['city_id'];
        $this->type = Type::from($this->originalData['type']);
        $this->city = $this->originalData['city_id'] ? DAO\City::fromSingleObjectContents($this->apiGateway, $this->originalData['city']) : null;
    }

    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::Street;
    }

    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'cityType' => $this->originalData['city']['type_id'] ? DAO\CityType::getById($this->apiGateway, $this->originalData['city']['type_id']) : null,
            default => $this->$name,
        };
    }
}
