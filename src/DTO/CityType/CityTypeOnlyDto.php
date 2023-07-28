<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\CityType;

use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;

final class CityTypeOnlyDto extends AbstractDTO implements CityTypeDtoInterface
{
    public function __construct(
        public string $id,
        public string $title
    ) {
    }

    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int
    {
        return ApiInt::fromStringOrNull($this->id)->getPositiveInt();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setId(int $value): static
    {
        return self::setPropertyFluently($this, 'id', (string)$value);
    }

    public function getTitle(): string
    {
        return ApiString::fromStringOrNull($this->title)->getStringEvenIfNullGiven();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTitle(string $value): static
    {
        return self::setPropertyFluently($this, 'title', $value);
    }
//    /** @param array{
//     *     "id": string,
//     *     "title": string,
//     * }
//     */

//    /** @inheritdoc */
//    public function getRequiredKeysForPostArray(): array
//    {
//        return ['title'];
//    }
}
