<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Hydrator\ApiBool;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;
use VetmanagerApiGateway\Hydrator\DtoPropertyList;

/** @psalm-suppress PropertyNotSetInConstructor, RedundantPropertyInitializationCheck - одобрено в доках PSALM для этого случая */
final class ComboManualNameDto extends AbstractDTO
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
        $instance->id = ApiInt::fromStringOrNull($originalData['id'])->positiveInt;
        $instance->title = ApiString::fromStringOrNull($originalData['title'])->nonEmptyString;
        $instance->isReadonly = ApiBool::fromStringOrNull($originalData['is_readonly'])->bool;
        $instance->name = ApiString::fromStringOrNull($originalData['name'])->nonEmptyString;
        return $instance;
    }

    /** @inheritdoc */
    public function getRequiredKeysForPostArray(): array
    {
        return ['title', 'name'];
    }

    /** @inheritdoc
     * @throws VetmanagerApiGatewayRequestException
     */
    protected function getSetValuesWithoutId(): array
    {
        return (new DtoPropertyList(
            $this,
            ['title', 'title'],
            ['isReadonly', 'is_readonly'],
            ['name', 'name'],
        ))->toArray();
    }
}
