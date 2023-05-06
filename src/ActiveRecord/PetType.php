<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\ActiveRecord\Trait\BasicDAOTrait;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\Enum\ApiRoute;
use VetmanagerApiGateway\DTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

final class PetType extends AbstractActiveRecord implements AllGetRequestsInterface
{
    use BasicDAOTrait;
    use AllGetRequestsTrait;

    /** @var DTO\BreedDto[] $breeds Уже получен при получении PetType. Нового АПИ-запроса не будет */
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
    public function __construct(ApiGateway $apiGateway, array $originalData)
    {
        $this->breeds = DTO\BreedDto::fromMultipleObjectsContents($this->apiGateway, $originalData['breeds']);
    }

    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::PetType;
    }

    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'self' => DAO\PetType::getById($this->apiGateway, $this->id),
            default => $this->$name,
        };
    }
}
