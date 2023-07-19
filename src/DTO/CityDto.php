<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;

final class CityDto // extends AbstractDTO
{
    /** @var string[] */
    public array $editedProperties = [];

    /** @param string|null $type_id Default: 1 */
    public function __construct(
        private string $id,
        private ?string $title,
        private ?string $type_id
    ) {
    }

    public function setProperty(string $propertyName, ?string $value): self
    {
        $clone = clone $this;
        $clone->$propertyName = $value;  #TODO maybe check property before (throw exception)
        $clone->editedProperties[] = $propertyName;
        return $clone;
    }

    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int
    {
        return ApiInt::fromStringOrNull($this->id)->getPositiveInt();
    }

    public function setId(int $id): self
    {
        return $this->setProperty('id', (string) $id);
    }

    public function getTitle(): string
    {
        return ApiString::fromStringOrNull($this->title)->getStringEvenIfNullGiven();
    }

    public function setTitle(string $title): self
    {
        return $this->setProperty('title', $title);
    }

    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getTypeId(): int
    {
        return ApiInt::fromStringOrNull($this->type_id)->getPositiveInt();
    }

    public function setTypeId(int $type_id): self
    {
        return $this->setProperty('type_id', (string)$type_id);
    }
//    /** @param array{
//     *     "id": string,
//     *     "title": string,
//     *     "type_id": string,
//     * } $originalDataArray
//     */
//
//    /** @inheritdoc */
//    public function getRequiredKeysForPostArray(): array #TODO check
//    {
//        return ['title', 'type_id'];
//    }
//
//    /** @inheritdoc
//     * @throws VetmanagerApiGatewayRequestException
//     */
//    protected function getSetValuesWithoutId(): array
//    {
//        return (new DtoPropertyList(
//            $this,
//            ['title', 'title'],
//            ['typeId', 'type_id'],
//        ))->toArray();
//    }
}
