<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\ComboManualName;

use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Hydrator\ApiBool;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;
use VetmanagerApiGateway\Hydrator\DtoPropertyList;

class ComboManualNameOnlyDto extends AbstractDTO
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
     *   } $originalDataArray 'comboManualItems' не используем
     * @throws VetmanagerApiGatewayException
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public static function fromApiResponseArray(array $originalDataArray): self
    {
        $instance = new self($originalDataArray);
        $instance->id = ApiInt::fromStringOrNull($originalDataArray['id'])->getPositiveInt();
        $instance->title = ApiString::fromStringOrNull($originalDataArray['title'])->getNonEmptyStringOrThrow();
        $instance->isReadonly = ApiBool::fromStringOrNull($originalDataArray['is_readonly'])->getBoolOrThrowIfNull();
        $instance->name = ApiString::fromStringOrNull($originalDataArray['name'])->getNonEmptyStringOrThrow();
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
