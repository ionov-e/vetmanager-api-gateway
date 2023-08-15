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
    /**
     * @param string|null $id
     * @param string|null $title
     * @param string|null $city_id
     * @param string|null $type
     */
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
        return ToInt::fromStringOrNull($this->id)->getPositiveIntOrThrow();
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
        return ToInt::fromStringOrNull($this->city_id)->getPositiveIntOrThrow();
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
    public function setTitle(?string $value): static
    {
        return self::setPropertyFluently($this, 'title', $value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCityId(?int $value): static
    {
        return self::setPropertyFluently($this, 'city_id', is_null($value) ? null : (string)$value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTypeFromString(?string $value): static
    {
        return self::setPropertyFluently($this, 'type', $value);
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTypeFromEnum(TypeEnum $value): static
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
