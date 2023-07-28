<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\PetType;

use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;

class PetTypeOnlyDto extends AbstractDTO
{
    /** @var positive-int */
    public int $id;
    public string $title;
    /** Default: '' */
    public string $picture;
    public string $type;

    /** @param array{
     *     id: string,
     *     title: string,
     *     picture: string,
     *     type: ?string,
     * } $originalDataArray
     * @throws VetmanagerApiGatewayException
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public static function fromApiResponseArray(array $originalDataArray): self
    {
        $instance = new self($originalDataArray);
        $instance->id = ApiInt::fromStringOrNull($originalDataArray['id'])->getPositiveInt();
        $instance->title = ApiString::fromStringOrNull($originalDataArray['title'])->getStringEvenIfNullGiven();
        $instance->picture = ApiString::fromStringOrNull($originalDataArray['picture'])->getStringEvenIfNullGiven();
        $instance->type = ApiString::fromStringOrNull($originalDataArray['type'])->getStringEvenIfNullGiven();
        return $instance;
    }

    /** @inheritdoc */
    protected function getSetValuesWithoutId(): array
    {
        return array_merge(
            property_exists($this, 'title') ? ['title' => $this->title] : [],
            property_exists($this, 'picture') ? ['picture' => $this->picture] : [],
            property_exists($this, 'type') ? ['type' => $this->type] : [],
        );
    }
}
