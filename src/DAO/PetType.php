<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DAO;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DAO\Interface\AllConstructorsInterface;
use VetmanagerApiGateway\DAO\Trait\AllConstructorsTrait;
use VetmanagerApiGateway\DTO;
use VetmanagerApiGateway\Enum\ApiRoute;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class PetType extends DTO\PetType implements AllConstructorsInterface
{
    use AllConstructorsTrait;

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
        $this->breeds = $this->getBreeds();
    }

    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::PetType;
    }

    /** @return DTO\Breed[]
     * @throws VetmanagerApiGatewayException
     */
    private function getBreeds(): array
    {
        return array_map(
            fn (array $breedArray): DTO\Breed => DTO\Breed::fromDecodedJson($this->apiGateway, $breedArray),
            $this->originalData['breeds']
        );
    }
}
