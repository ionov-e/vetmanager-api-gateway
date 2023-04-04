<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\DAO;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO;
use VetmanagerApiGateway\DTO\DAO\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\DTO\DAO\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\DTO\DAO\Trait\BasicDAOTrait;
use VetmanagerApiGateway\DTO\Enum\ApiRoute;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class Breed extends DTO\Breed implements AllGetRequestsInterface
{
    use BasicDAOTrait, AllGetRequestsTrait;

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

        $this->type = DTO\PetType::fromSingleObjectContents($this->apiGateway, $this->originalData['petType']);
    }

    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::Breed;
    }
}