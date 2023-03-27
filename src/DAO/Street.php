<?php declare(strict_types=1);

namespace VetmanagerApiGateway\DAO;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DAO\Interface\AllConstructorsInterface;
use VetmanagerApiGateway\DAO\Trait\AllConstructorsTrait;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Enum\ApiRoute;
use VetmanagerApiGateway\Enum\Street\Type;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/**
 * @property-read CityType $cityType
 */
class Street extends AbstractDTO implements AllConstructorsInterface
{
    use AllConstructorsTrait;

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
    readonly protected array $originalData;

    /** @throws VetmanagerApiGatewayException */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = (int)$this->originalData['id'];
        $this->title = (string)$this->originalData['title'];
        $this->cityId = (int)$this->originalData['city_id'];
        $this->type = Type::from($this->originalData['type']);
        $this->city = $this->originalData['city_id'] ? City::fromDecodedJson($this->apiGateway, $this->originalData['city']) : null;
  }

    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'cityType' => $this->originalData['city']['type_id'] ? CityType::fromRequestById($this->apiGateway, $this->originalData['city']['type_id']) : null,
            default => $this->$name,
        };
    }

    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::Street;
    }
}
