<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use VetmanagerApiGateway\DO\IntContainer;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class PetTypeDto extends AbstractDTO
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
     * } $originalData
     * @throws VetmanagerApiGatewayException
     */
    public function __construct(array $originalData)
    {
        $this->id = IntContainer::fromStringOrNull($originalData['id'])->positiveInt;
        $this->title = StringContainer::fromStringOrNull($originalData['title'])->string;
        $this->picture = StringContainer::fromStringOrNull($originalData['picture'])->string;
        $this->type = StringContainer::fromStringOrNull($originalData['type'])->string;
    }

    /** @inheritdoc */
    public function getRequiredKeysForPostArray(): array
    {
        return ['title'];
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
