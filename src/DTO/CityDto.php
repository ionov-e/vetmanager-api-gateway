<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;
use VetmanagerApiGateway\Hydrator\DtoPropertyList;

/** @psalm-suppress PropertyNotSetInConstructor, RedundantPropertyInitializationCheck - одобрено в доках PSALM для этого случая */
final class CityDto extends AbstractDTO
{
    /** @var positive-int */
    public int $id;
    public string $title;
    /** @var positive-int Default: 1 */
    public int $typeId;

    /** @param array{
     *     "id": string,
     *     "title": string,
     *     "type_id": string,
     * } $originalData
     * @psalm-suppress MoreSpecificImplementedParamType
     * @throws VetmanagerApiGatewayResponseException
     */
    public static function fromApiResponseArray(array $originalData): self
    {
        $instance = new self();
        $instance->id = ApiInt::fromStringOrNull($originalData['id'])->positiveInt;
        $instance->title = ApiString::fromStringOrNull($originalData['title'])->string;
        $instance->typeId = ApiInt::fromStringOrNull($originalData['type_id'])->positiveInt;
        return $instance;
    }

    /** @inheritdoc */
    public function getRequiredKeysForPostArray(): array #TODO check
    {
        return ['title', 'type_id'];
    }

    /** @inheritdoc
     * @throws VetmanagerApiGatewayRequestException
     */
    protected function getSetValuesWithoutId(): array
    {
        return (new DtoPropertyList(
            $this,
            ['title', 'title'],
            ['typeId', 'type_id'],
        ))->toArray();
    }
}
