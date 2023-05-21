<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use VetmanagerApiGateway\DTO\Enum\Unit\Status;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;
use VetmanagerApiGateway\Hydrator\DtoPropertyList;

/** @psalm-suppress PropertyNotSetInConstructor, RedundantPropertyInitializationCheck - одобрено в доках PSALM для этого случая */
final class UnitDto extends AbstractDTO
{

    public int $id;
    public string $title;
    /** Default: 'active' */
    public Status $status;

    /** @param array{
     *     "id": string,
     *     "title": string,
     *     "status": string,
     * } $originalData
     * @psalm-suppress MoreSpecificImplementedParamType
     * @throws VetmanagerApiGatewayResponseException
     */
    public static function fromApiResponseArray(array $originalData): self
    {
        $instance = new self();
        $instance->id = ApiInt::fromStringOrNull($originalData['id'])->positiveInt;
        $instance->title = ApiString::fromStringOrNull($originalData['title'])->string;
        $instance->status = Status::from($originalData['status']);
        return $instance;
    }

    /** @inheritdoc */
    public function getRequiredKeysForPostArray(): array #TODO check
    {
        return ['title', 'status'];
    }

    /** @inheritdoc
     * @throws VetmanagerApiGatewayRequestException
     */
    protected function getSetValuesWithoutId(): array
    {
        return (new DtoPropertyList(
            $this,
            ['title', 'title'],
            ['status', 'status'],
        ))->toArray();
    }
}
