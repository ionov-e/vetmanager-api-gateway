<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\CityType;

use VetmanagerApiGateway\ApiDataInterpreter\ToInt;
use VetmanagerApiGateway\ApiDataInterpreter\ToString;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

final class CityTypeOnlyDto extends AbstractDTO implements CityTypeDtoInterface
{
    /**
     * @param int|null $id
     * @param string|null $title
     */
    public function __construct(
        public ?int $id,
        public ?string $title
    ) {
    }

    /** @return positive-int
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getId(): int
    {
        return (new ToInt($this->id))->getPositiveIntOrThrow();
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
//    /** @param array{
//     *     "id": string,
//     *     "title": string,
//     * }
//     */
}
