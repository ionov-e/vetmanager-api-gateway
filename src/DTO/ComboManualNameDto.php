<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use VetmanagerApiGateway\DO\BoolContainer;
use VetmanagerApiGateway\DO\IntContainer;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/** @psalm-suppress PropertyNotSetInConstructor, RedundantPropertyInitializationCheck - одобрено в доках PSALM для этого случая */
class ComboManualNameDto extends AbstractDTO
{
    /** @var positive-int */
    public int $id;
    /** @var non-empty-string BD default: '' */
    public string $title;
    /** Default: 0 */
    public bool $isReadonly;
    /** @var non-empty-string BD default: '' */
    public string $name;

    /** @param array{
     *       id: string,
     *       title: string,
     *       is_readonly: string,
     *       name: string,
     *       comboManualItems?: array
     *   } $originalData 'comboManualItems' не используем
     * @throws VetmanagerApiGatewayException
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public static function fromApiResponseArray(array $originalData): self
    {
        $instance = new self();
        $instance->id = IntContainer::fromStringOrNull($originalData['id'])->positiveInt;
        $instance->title = StringContainer::fromStringOrNull($originalData['title'])->nonEmptyString;
        $instance->isReadonly = BoolContainer::fromStringOrNull($originalData['is_readonly'])->bool;
        $instance->name = StringContainer::fromStringOrNull($originalData['name'])->nonEmptyString;
        return $instance;
    }

    /** @inheritdoc */
    public function getRequiredKeysForPostArray(): array
    {
        return ['title', 'name'];
    }

    /** @inheritdoc */
    protected function getSetValuesWithoutId(): array
    {
        return array_merge(
            isset($this->title) ? ['title' => $this->title] : [],
            isset($this->isReadonly) ? ['is_readonly' => (int)$this->isReadonly] : [],
            isset($this->name) ? ['name' => $this->name] : [],
        );
    }
}
