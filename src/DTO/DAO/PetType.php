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

class PetType extends DTO\PetType implements AllGetRequestsInterface
{
    use BasicDAOTrait, AllGetRequestsTrait;

    /** @var DTO\Breed[] $breeds Уже получен при получении PetType. Нового АПИ-запроса не будет */
    public array $breeds;

    /** @var array{
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
     */
    protected readonly array $originalData;

    /** @throws VetmanagerApiGatewayException */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);
        $this->breeds = DTO\Breed::fromMultipleObjectsContents($this->apiGateway, $this->originalData['breeds']);
    }

    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::PetType;
    }
}
