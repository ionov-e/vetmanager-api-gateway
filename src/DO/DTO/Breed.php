<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO\DTO;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\IntContainer;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/**
 * @property-read DAO\Breed $self
 * @property-read DAO\PetType $type
 */
class Breed extends AbstractDTO
{
    /** @var positive-int */
    public int $id;
    /** @var non-empty-string */
    public string $title;
    /** @var positive-int */
    public int $typeId;

    /** @param array{
     *       "id": string,
     *       "title": string,
     *       "pet_type_id": string,
     *   } $originalData
     * @throws VetmanagerApiGatewayException
     */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = IntContainer::fromStringOrNull($this->originalData['id'])->positiveInt;
        $this->title = StringContainer::fromStringOrNull($this->originalData['title'])->stringOrThrowIfNull;
        $this->typeId = IntContainer::fromStringOrNull($this->originalData['pet_type_id'])->positiveInt;
    }

    /** @throws VetmanagerApiGatewayException
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'self' => DAO\Breed::getById($this->apiGateway, $this->id),
            'type' => DAO\PetType::getById($this->apiGateway, $this->typeId),
            default => $this->$name,
        };
    }
}
