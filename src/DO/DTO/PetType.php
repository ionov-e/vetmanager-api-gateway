<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO\DTO;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\IntContainer;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/** @property-read DAO\PetType $self */
class PetType extends AbstractDTO
{
    /** @var positive-int */
    public int $id;
    public string $title;
    /** Default: '' */
    public string $picture;
    public string $type;

    /** @param array{
     *     "id": string,
     *     "title": string,
     *     "picture": string,
     *     "type": ?string,
     *     "breeds"?: array
     * } $originalData
     * @throws VetmanagerApiGatewayException
     */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = IntContainer::fromStringOrNull($originalData['id'])->positiveInt;
        $this->title = StringContainer::fromStringOrNull($originalData['title'])->string;
        $this->picture = StringContainer::fromStringOrNull($originalData['picture'])->string;
        $this->type = StringContainer::fromStringOrNull($originalData['type'])->string;
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
