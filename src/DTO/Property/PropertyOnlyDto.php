<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Property;

use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;
use VetmanagerApiGateway\Hydrator\DtoPropertyList;

final class PropertyOnlyDto extends AbstractDTO
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
     * } $originalDataArray
     * @throws VetmanagerApiGatewayException
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public static function fromApiResponseArray(array $originalDataArray): self
    {
        $instance = new self($originalDataArray);
        $instance->id = ApiInt::fromStringOrNull($originalDataArray['id'])->getPositiveInt();
        $instance->name = ApiString::fromStringOrNull($originalDataArray['property_name'])->getStringEvenIfNullGiven();
        $instance->value = ApiString::fromStringOrNull($originalDataArray['property_value'])->getStringEvenIfNullGiven();
        $instance->title = ApiString::fromStringOrNull($originalDataArray['property_title'])->getStringEvenIfNullGiven();
        $instance->clinicId = ApiInt::fromStringOrNull($originalDataArray['clinic_id'])->getPositiveIntOrNull();
        return $instance;
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
