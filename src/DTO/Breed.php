<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DAO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/**
 * @property-read DAO\Breed $self
 * @property-read DAO\PetType $type
 */
class Breed extends AbstractDTO
{
    public int $id;
    public string $title;
    public int $typeId;

    /** @var array{
     *       "id": string,
     *       "title": string,
     *       "pet_type_id": string,
     *   } $originalData
     */
    protected readonly array $originalData;

    /** @throws VetmanagerApiGatewayException */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = (int)$this->originalData['id'];
        $this->title = (string)$this->originalData['title'];
        $this->typeId = (int)$this->originalData['pet_type_id'];
    }

    /** @throws VetmanagerApiGatewayException
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'self' => DAO\Breed::fromRequestById($this->apiGateway, $this->id),
            'type' => DAO\PetType::fromRequestById($this->apiGateway, $this->typeId),
            default => $this->$name,
        };
    }
}
