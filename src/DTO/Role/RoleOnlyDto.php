<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Role;

use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Hydrator\ApiBool;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;
use VetmanagerApiGateway\Hydrator\DtoPropertyList;

final class RoleOnlyDto extends AbstractDTO
{
    /** @var positive-int */
    public int $id;
    public string $name;
    /** Default: '0' */
    public bool $isSuper;

    /** @param array{
     *     "id": numeric-string,
     *     "name": string,
     *     "super": string,
     * } $originalDataArray
     * @throws VetmanagerApiGatewayException
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public static function fromApiResponseArray(array $originalDataArray): self
    {
        $instance = new self($originalDataArray);
        $instance->id = ApiInt::fromStringOrNull($originalDataArray['id'])->getPositiveInt();
        $instance->name = ApiString::fromStringOrNull($originalDataArray['name'])->getStringEvenIfNullGiven();
        $instance->isSuper = ApiBool::fromStringOrNull($originalDataArray['super'])->getBoolOrThrowIfNull();
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
            ['name', 'name'],
            ['isSuper', 'super'],
        ))->toArray();
    }
}
