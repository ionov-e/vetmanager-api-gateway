<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\DAO;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DAO\Interface\AllConstructorsInterface;
use VetmanagerApiGateway\DAO\Trait\AllConstructorsTrait;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Enum\ApiRoute;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/** @property-read CityType $type */
class City extends AbstractDTO implements AllConstructorsInterface
{
    use AllConstructorsTrait;

    public int $id;
    public string $title;
    /** Default: 1 */
    public int $typeId;

    /** @var array{
     *     "id": string,
     *     "title": string,
     *     "type_id": string,
     * } $originalData
     */
    readonly protected array $originalData;

    /** @throws VetmanagerApiGatewayException */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = (int)$this->originalData['id'];
        $this->title = (string)$this->originalData['title'];
        $this->typeId = (int)$this->originalData['type_id'];
    }

    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::City;
    }

    /** @throws VetmanagerApiGatewayException
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'type' => CityType::fromRequestById($this->apiGateway, $this->typeId),
            default => $this->$name,
        };
    }
}
