<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO\DTO;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/** @property-read DAO\PetType $self */
class PetType extends AbstractDTO
{
    public int $id;
    public string $title;
    /** Default: '' */
    public string $picture;
    public ?string $type;

    /** @var array{
     *     "id": string,
     *     "title": string,
     *     "picture": string,
     *     "type": ?string,
     *     }
     * } $originalData
     */
    protected readonly array $originalData;

    /** @throws VetmanagerApiGatewayException */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = (int)$this->originalData['id'];
        $this->title = (string)$this->originalData['title'];
        $this->picture = (string)$this->originalData['picture'];
        $this->type = $this->originalData['type'] ? (string)$this->originalData['type'] : null;
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
