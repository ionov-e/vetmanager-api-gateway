<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\City;

use VetmanagerApiGateway\ApiDataInterpreter\ToInt;
use VetmanagerApiGateway\ApiDataInterpreter\ToString;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

final class CityOnlyDto extends AbstractDTO implements CityDtoInterface
{
    /**
     * @param string|null $id
     * @param string|null $title
     * @param string|null $type_id Default: 1
     */
    public function __construct(
        protected ?string $id,
        protected ?string $title,
        protected ?string $type_id
    )
    {
    }

    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int
    {
        return ToInt::fromStringOrNull($this->id)->getPositiveInt();
    }

    public function setId(int $value): static
    {
        return self::setPropertyFluently($this, 'id', (string)$value);
    }

    public function getTitle(): string
    {
        return ToString::fromStringOrNull($this->title)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTitle(string $value): static
    {
        return self::setPropertyFluently($this, 'title', $value);
    }

    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getTypeId(): int
    {
        return ToInt::fromStringOrNull($this->type_id)->getPositiveInt();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTypeId(int $value): static
    {
        return self::setPropertyFluently($this, 'type_id', (string)$value);
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
