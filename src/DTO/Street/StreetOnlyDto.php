<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\Street;

use VetmanagerApiGateway\ApiDataInterpreter\ToInt;
use VetmanagerApiGateway\ApiDataInterpreter\ToString;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

class StreetOnlyDto extends AbstractDTO implements StreetOnlyDtoInterface
{
    public function __construct(
        protected ?string $id,
        protected ?string $title,
        protected ?string $city_id,
        protected ?string $type
    ) {
    }

    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int
    {
        return ToInt::fromStringOrNull($this->id)->getPositiveInt();
    }

    /** Default: '' */
    public function getTitle(): ?string
    {
        return ToString::fromStringOrNull($this->title)->getStringEvenIfNullGiven();
    }

    /** @return positive-int В БД Default: '0' (но никогда не видел 0)
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getCityId(): int
    {
        return ToInt::fromStringOrNull($this->city_id)->getPositiveInt();
    }

    /** Default: 'street'*/
    public function getTypeAsString(): ?string
    {
        return $this->type;
    }

    /** Default: 'street'*/
    public function getTypeAsEnum(): TypeEnum
    {
        return TypeEnum::from($this->type);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setId(int $value): static
    {
        return self::setPropertyFluently($this, 'id', (string)$value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTitle(?string $value): static
    {
        return self::setPropertyFluently($this, 'title', $value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCityId(?int $value): static
    {
        return self::setPropertyFluently($this, 'city_id', (string)$value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTypeAsString(?string $value): static
    {
        return self::setPropertyFluently($this, 'type', $value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTypeAsEnum(TypeEnum $value): static
    {
        return self::setPropertyFluently($this, 'type', $value->value);
    }

//    /** @param array{
//     *     "id": string,
//     *     "title": string,
//     *     "city_id": string,
//     *     "type": string,
//     *     "city"?: array{
//     *              "id": string,
//     *              "title": ?string,
//     *              "type_id": ?string
//     *     }
//     * } $originalDataArray
//     */
}
