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

final class PetType extends DTO\PetType implements AllGetRequestsInterface
{
    use BasicDAOTrait;
    use AllGetRequestsTrait;

    /** @var DTO\Breed[] $breeds Уже получен при получении PetType. Нового АПИ-запроса не будет */
    public array $breeds;

    /** @param array{
     *     "id": string,
     *     "title": string,
     *     "picture": string,
     *     "type": ?string,
     *     "breeds": array{int, array{
     *              "id": string,
     *              "title": string,
     *              "pet_type_id": string,
     *          }
     *     }
     * } $originalData
     * @throws VetmanagerApiGatewayException
     */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);
        $this->breeds = DTO\Breed::fromMultipleObjectsContents($this->apiGateway, $originalData['breeds']);
    }

    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::PetType;
    }
}
