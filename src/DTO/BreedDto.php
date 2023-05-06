<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use VetmanagerApiGateway\DO\IntContainer;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class BreedDto
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
     *       "petType"?: array
     *   } $originalData
     * @throws VetmanagerApiGatewayException
     */
    public function __construct(array $originalData)
    {
        $this->id = IntContainer::fromStringOrNull($originalData['id'])->positiveInt;
        $this->title = StringContainer::fromStringOrNull($originalData['title'])->stringOrThrowIfNull;
        $this->typeId = IntContainer::fromStringOrNull($originalData['pet_type_id'])->positiveInt;
    }
}
