<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use VetmanagerApiGateway\DO\IntContainer;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class BreedDto extends AbstractDTO
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

    /** @inheritdoc */
    public function getRequiredKeysForPostArray(): array
    {
        return ['title', 'pet_type_id'];
    }

    /** @inheritdoc */
    protected function getSetValuesWithoutId(): array
    {
        return array_merge(
            isset($this->title) ? ['title' => $this->title] : [],
            isset($this->typeId) ? ['pet_type_id' => (string) $this->typeId] : [],
        );
    }
}
