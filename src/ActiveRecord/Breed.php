<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Enum\ApiRoute;
use VetmanagerApiGateway\ActiveRecord\Enum\Source;
use VetmanagerApiGateway\ActiveRecord\Interface\AllRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllRequestsTrait;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO\BreedDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/**
 * @property positive-int id
 * @property non-empty-string title
 * @property positive-int typeId
 */
final class Breed extends AbstractActiveRecord implements AllRequestsInterface
{
    use AllRequestsTrait;

    private readonly BreedDto $originalDto;
    protected BreedDto $userMadeDto;

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
    private function __construct(ApiGateway $apiGateway, array $originalData, Source $sourceOfData = Source::Other)
    {
        parent::__construct($apiGateway, $originalData, $sourceOfData);
        $this->originalDto = new BreedDto($originalData);
        $this->userMadeDto = new BreedDto([]);
    }

    /** @throws VetmanagerApiGatewayException */
    public static function fromArrayAndTypeOfGet(ApiGateway $apiGateway, array $originalData, Source $typeOfGet = Source::Other): self
    {
        return ($typeOfGet === Source::ById)
            ? self::fromArrayGetById($apiGateway, $originalData)
            : self::fromArrayGetAll($apiGateway, $originalData);
    }

    /** @throws VetmanagerApiGatewayException */
    public static function fromArrayGetById(ApiGateway $apiGateway, array $originalData): self
    {
        return new self($apiGateway, $originalData, Source::ById);
    }

    /** @throws VetmanagerApiGatewayException */
    public static function fromArrayGetAll(ApiGateway $apiGateway, array $originalData): self
    {
        return new self($apiGateway, $originalData, Source::Other);
    }

    /** @throws VetmanagerApiGatewayException */
    public static function fromArrayGetByQuery(ApiGateway $apiGateway, array $originalData): self
    {
        return self::fromArrayGetAll($apiGateway, $originalData);
    }

    /** @return ApiRoute::Breed */
    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::Breed;
    }

    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'type' => ($this->sourceOfData == Source::ById)
                ? PetType::fromArrayGetAll($this->apiGateway, $this->originalData['petType']) #TODO redo
                : PetType::getById($this->apiGateway, $this->typeId),
            default => $this->originalDto->$name,
        };
    }
}
