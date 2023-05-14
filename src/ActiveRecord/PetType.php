<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Enum\ApiRoute;
use VetmanagerApiGateway\ActiveRecord\Enum\Source;
use VetmanagerApiGateway\ActiveRecord\Interface\AllRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO;
use VetmanagerApiGateway\DTO\PetTypeDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

final class PetType extends AbstractActiveRecord implements AllRequestsInterface
{
    use AllGetRequestsTrait;

    private readonly PetTypeDto $originalDto;
    protected PetTypeDto $userMadeDto;
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
    private function __construct(ApiGateway $apiGateway, array $originalData, Source $sourceOfData = Source::Other)
    {
        parent::__construct($apiGateway, $originalData, $sourceOfData);
        $this->originalDto = new PetTypeDto($originalData);
        $this->userMadeDto = new PetTypeDto([]);
    }

    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::PetType;
    }

    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'breeds' => DTO\BreedDto::fromMultipleObjectsContents($this->apiGateway, $this->originalData['breeds']),
            default => $this->$name,
        };
    }
}
