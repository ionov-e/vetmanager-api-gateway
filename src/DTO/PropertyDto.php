<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;
use VetmanagerApiGateway\Hydrator\DtoPropertyList;

/** @psalm-suppress PropertyNotSetInConstructor, RedundantPropertyInitializationCheck - одобрено в доках PSALM для этого случая */
final class PropertyDto extends AbstractDTO
{
    /** @var positive-int */
    public int $id;
    /** Default: '' */
    public string $name;
    public string $value;
    public ?string $title;
    /** @var ?positive-int Default: '0' (вместо него отдаем null) */
    public ?int $clinicId;

    /** @param array{
     *     "id": string,
     *     "property_name": string,
     *     "property_value": string,
     *     "property_title": ?string,
     *     "clinic_id": string
     * } $originalData
     * @throws VetmanagerApiGatewayException
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public static function fromApiResponseArray(array $originalData): self
    {
        $instance = new self();
        $instance->id = ApiInt::fromStringOrNull($originalData['id'])->positiveInt;
        $instance->name = ApiString::fromStringOrNull($originalData['property_name'])->string;
        $instance->value = ApiString::fromStringOrNull($originalData['property_value'])->string;
        $instance->title = ApiString::fromStringOrNull($originalData['property_title'])->string;
        $instance->clinicId = ApiInt::fromStringOrNull($originalData['clinic_id'])->positiveIntOrNull;
        return $instance;
    }

    /** @inheritdoc */
    public function getRequiredKeysForPostArray(): array
    {
        return [];
    }

    /** @inheritdoc
     * @throws VetmanagerApiGatewayRequestException
     */
    protected function getSetValuesWithoutId(): array
    {
        return (new DtoPropertyList(
            $this,
            ['name', 'property_name'],
            ['value', 'property_value'],
            ['title', 'property_title'],
            ['clinicId', 'clinic_id'],
        ))->toArray();
    }
}
