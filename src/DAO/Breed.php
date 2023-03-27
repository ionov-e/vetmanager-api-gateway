<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DAO;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DAO\Interface\AllConstructorsInterface;
use VetmanagerApiGateway\DAO\Trait\AllConstructorsTrait;
use VetmanagerApiGateway\DTO;
use VetmanagerApiGateway\Enum\ApiRoute;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class Breed extends DTO\Breed implements AllConstructorsInterface
{
    use AllConstructorsTrait;

    /** Уже получен. Не будет дополнительного АПИ запроса */
    public DTO\PetType $type;

    /** @var array{
     *     "id": string,
     *     "title": string,
     *     "pet_type_id": string,
     *     "petType": array{
     *          "id": string,
     *          "title": string,
     *          "picture": string,
     *          "type": ?string,
     *      }
     * } $originalData
     */
    protected readonly array $originalData;

    /** @throws VetmanagerApiGatewayException */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->type = DTO\PetType::fromDecodedJson($this->apiGateway, $this->originalData['petType']);
    }

    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::Breed;
    }
}
