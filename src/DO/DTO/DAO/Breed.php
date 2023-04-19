<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO\DTO\DAO;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\DTO;
use VetmanagerApiGateway\DO\DTO\DAO\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\DO\DTO\DAO\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\DO\DTO\DAO\Trait\BasicDAOTrait;
use VetmanagerApiGateway\DO\Enum\ApiRoute;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

final class Breed extends DTO\Breed implements AllGetRequestsInterface
{
    use BasicDAOTrait;
    use AllGetRequestsTrait;

    /** Уже получен. Не будет дополнительного АПИ запроса */
    public DTO\PetType $type;

    /** @param array{
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
     * @throws VetmanagerApiGatewayException
     */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->type = DTO\PetType::fromSingleObjectContents($this->apiGateway, $this->originalData['petType']);
    }

    /** @return ApiRoute::Breed */
    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::Breed;
    }
}
