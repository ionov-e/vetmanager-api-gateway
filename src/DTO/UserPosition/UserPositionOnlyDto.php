<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\UserPosition;

use DateInterval;
use VetmanagerApiGateway\ApiDataInterpreter\DtoPropertyList;
use VetmanagerApiGateway\ApiDataInterpreter\ToDateInterval;
use VetmanagerApiGateway\ApiDataInterpreter\ToInt;
use VetmanagerApiGateway\ApiDataInterpreter\ToString;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;

final class UserPositionOnlyDto extends AbstractDTO
{
    public int $id;
    public string $title;
    /** Default: '00:30:00'. TypeEnum in DB: 'time'. Null if '00:00:00' */
    public ?DateInterval $admissionLength;

    /** @param array{
     *     id: string,
     *     title: string,
     *     admission_length: string
     * } $originalDataArray
     * @throws VetmanagerApiGatewayException
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public static function fromApiResponseArray(array $originalDataArray): self
    {
        $instance = new self($originalDataArray);
        $instance->id = ToInt::fromStringOrNull($originalDataArray['id'])->getPositiveInt();
        $instance->title = ToString::fromStringOrNull($originalDataArray['title'])->getStringEvenIfNullGiven();
        $instance->admissionLength = ToDateInterval::fromStringHMS($originalDataArray['admission_length'])->getDateIntervalOrNull();
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
            ['admissionLength', 'admission_length'],
        ))->toArray();
    }
}
