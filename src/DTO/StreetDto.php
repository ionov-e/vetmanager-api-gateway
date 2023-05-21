<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use VetmanagerApiGateway\DTO\Enum\Street\Type;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;
use VetmanagerApiGateway\Hydrator\DtoPropertyList;

/** @psalm-suppress PropertyNotSetInConstructor, RedundantPropertyInitializationCheck - одобрено в доках PSALM для этого случая */
final class StreetDto extends AbstractDTO
{

    /** @var positive-int */
    public int $id;
    /** Default: '' */
    public string $title;
    /** Default: 'street'*/
    public Type $type;
    /** @var positive-int В БД Default: '0' (но никогда не видел 0) */
    public int $cityId;

    /** @param array{
     *     "id": string,
     *     "title": string,
     *     "city_id": string,
     *     "type": string,
     *     "city"?: array{
     *              "id": string,
     *              "title": ?string,
     *              "type_id": ?string
     *     }
     * } $originalData
     * @throws VetmanagerApiGatewayException
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public static function fromApiResponseArray(array $originalData): self
    {
        $instance = new self();
        $instance->id = ApiInt::fromStringOrNull($originalData['id'])->positiveInt;
        $instance->title = ApiString::fromStringOrNull($originalData['title'])->string;
        $instance->cityId = ApiInt::fromStringOrNull($originalData['city_id'])->positiveInt;
        $instance->type = Type::from($originalData['type']);
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
            ['title', 'title'],
            ['cityId', 'city_id'],
            ['type', 'type'],
        ))->toArray();
    }
}
