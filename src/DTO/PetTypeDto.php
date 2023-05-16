<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use VetmanagerApiGateway\DO\IntContainer;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/** @psalm-suppress PropertyNotSetInConstructor, RedundantPropertyInitializationCheck - одобрено в доках PSALM для этого случая */
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
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public static function fromApiResponseArray(array $originalData): self
    {
        $instance = new self();
        $instance->id = IntContainer::fromStringOrNull($originalData['id'])->positiveInt;
        $instance->title = StringContainer::fromStringOrNull($originalData['title'])->string;
        $instance->picture = StringContainer::fromStringOrNull($originalData['picture'])->string;
        $instance->type = StringContainer::fromStringOrNull($originalData['type'])->string;
        return $instance;
    }

    /** @inheritdoc */
    public function getRequiredKeysForPostArray(): array #TODO check
    {
        return ['title'];
    }

    /** @inheritdoc */
    protected function getSetValuesWithoutId(): array
    {
        return array_merge(
            isset($this->title) ? ['title' => $this->title] : [],
            isset($this->picture) ? ['picture' => $this->picture] : [],
            isset($this->type) ? ['type' => $this->type] : [],
        );
    }
}
