<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Unit;

use VetmanagerApiGateway\ApiDataInterpreter\DtoPropertyList;
use VetmanagerApiGateway\ApiDataInterpreter\ToInt;
use VetmanagerApiGateway\ApiDataInterpreter\ToString;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

final class UnitOnlyDto extends AbstractDTO
{

    public int $id;
    public string $title;
    /** Default: 'active' */
    public StatusEnum $status;

    /** @param array{
     *     "id": string,
     *     "title": string,
     *     "status": string,
     * } $originalDataArray
     * @psalm-suppress MoreSpecificImplementedParamType
     * @throws VetmanagerApiGatewayResponseException
     */
    public static function fromApiResponseArray(array $originalDataArray): self
    {
        $instance = new self($originalDataArray);
        $instance->id = ToInt::fromStringOrNull($originalDataArray['id'])->getPositiveInt();
        $instance->title = ToString::fromStringOrNull($originalDataArray['title'])->getStringEvenIfNullGiven();
        $instance->status = StatusEnum::from($originalDataArray['status']);
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
