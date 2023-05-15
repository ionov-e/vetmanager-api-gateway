<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
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
 * @property-read PetType type
 */
final class Breed extends AbstractActiveRecord implements AllRequestsInterface
{
    use AllRequestsTrait;

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
     */
    private function __construct(ApiGateway $apiGateway, array $originalData, Source $sourceOfData = Source::OnlyBasicDto)
    {
        parent::__construct($apiGateway, $originalData, BreedDto::class, 'breed', $sourceOfData);
    }

    /** @return ApiModel::Breed */
    public static function getApiModel(): ApiModel
    {
        return ApiModel::Breed;
    }

//    /** @throws VetmanagerApiGatewayException */
//    public static function fromSingleObjectArrayAndTypeOfGet(ApiGateway $apiGateway, array $originalData, Source $typeOfSource = Source::OnlyBasicDto): self
//    {
//        return match ($typeOfSource) {
//            Source::GetById => self::fromSingleArrayUsingGetById($apiGateway, $originalData),
//            Source::GetByAllList => self::fromSingleArrayUsingGetAll($apiGateway, $originalData),
//            Source::GetByQuery => self::fromSingleArrayUsingGetByQuery($apiGateway, $originalData),
//            Source::OnlyBasicDto => throw new \Exception('To be implemented')
//        };
//    }

    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'type' => ($this->sourceOfData == Source::GetById)
                ? PetType::fromSingleArrayUsingGetAll($this->apiGateway, $this->originalData['petType']) #TODO redo
                : PetType::getById($this->apiGateway, $this->typeId),
            default => $this->originalDto->$name,
        };
    }
}
