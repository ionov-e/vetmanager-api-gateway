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
use VetmanagerApiGateway\DO\IntContainer;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/**
 * @property-read CityType $cityType
 */
final class Street extends AbstractDTO implements AllGetRequestsInterface
{
    use BasicDAOTrait;
    use AllGetRequestsTrait;

    /** @var positive-int */
    public int $id;
    /** Default: '' */
    public string $title;
    /** Default: 'street'*/
    public Type $type;
    /** @var positive-int В БД Default: '0' (но никогда не видел 0) */
    public int $cityId;
    public ?City $city;

    /** @param array{
     *     "id": string,
     *     "title": string,
     *     "city_id": string,
     *     "type": string,
     *     "city"?: array{
     *              "id": string,
     *              "title": ?string,
     *              "type_id": ?string
     *     }
     * } $originalData
     * @throws VetmanagerApiGatewayException
     */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = IntContainer::fromStringOrNull($originalData['id'])->positiveInt;
        $this->title = StringContainer::fromStringOrNull($originalData['title'])->string;
        $this->cityId = IntContainer::fromStringOrNull($originalData['city_id'])->positiveInt;
        $this->type = Type::from($originalData['type']);
        $this->city = !empty($originalData['city'])
            ? DAO\City::fromSingleObjectContents($this->apiGateway, $originalData['city'])
            : null;
    }

    /** @return ApiRoute::Street */
    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::Street;
    }

    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'cityType' => $this->originalData['city']['type_id']
                ? DAO\CityType::getById($this->apiGateway, $this->originalData['city']['type_id'])
                : null,
            default => $this->$name,
        };
    }
}
