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

/**
 * @property-read ActiveRecord\PetType $type
 */
final class Breed extends AbstractActiveRecord implements AllGetRequestsInterface
{
    use BasicDAOTrait;
    use AllGetRequestsTrait;

    private readonly DTO\BreedDto $originalDto;
    private DTO\BreedDto $userMadeDto;

    /** Уже получен. Не будет дополнительного АПИ запроса */
    public DTO\PetTypeDto $type;

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
    public function __construct(ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->originalDto = new DTO\BreedDto($originalData);
        $this->type = new DTO\PetTypeDto($originalData['petType']);
    }

    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'type' => ActiveRecord\PetType::getById($this->apiGateway, $this->typeId),
            default => $this->$name,
        };
    }

    public function __set($name, $value)
    {
        echo "Setting '$name' to '$value'\n";
        //        $this->data[$name] = $value;
    }

    /** @return ApiRoute::Breed */
    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::Breed;
    }
}
