<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\UserPosition;

use DateInterval;
use VetmanagerApiGateway\ApiDataInterpreter\ToDateInterval;
use VetmanagerApiGateway\ApiDataInterpreter\ToInt;
use VetmanagerApiGateway\ApiDataInterpreter\ToString;
use VetmanagerApiGateway\DTO\AbstractDTO;

class UserPositionOnlyDto extends AbstractDTO implements UserPositionOnlyDtoInterface
{
    /**
     * @param string|null $id
     * @param string|null $title
     * @param string|null $admission_length
     */
    public function __construct(
        protected ?string $id,
        protected ?string $title,
        protected ?string $admission_length
    ) {
    }

    public function getId(): int
    {
        return ToInt::fromStringOrNull($this->id)->getPositiveIntOrThrow();
    }

    public function getTitle(): ?string
    {
        return ToString::fromStringOrNull($this->title)->getStringEvenIfNullGiven();
    }

    public function getAdmissionLengthAsString(): ?string
    {
        return $this->admission_length;
    }

    public function getAdmissionLengthAsDateInterval(): ?DateInterval
    {
        return ToDateInterval::fromStringHMS($this->admission_length)->getDateIntervalOrNull();
    }

    public function setId(int $value): static
    {
        return self::setPropertyFluently($this, 'id', (string)$value);
    }

    public function setTitle(?string $value): static
    {
        return self::setPropertyFluently($this, 'title', $value);
    }

    public function setAdmissionLengthFromString(?string $value): static
    {
        return self::setPropertyFluently($this, 'admission_length', $value);
    }

    public function setAdmissionLengthFromDateInterval(DateInterval $value): static
    {
        return self::setPropertyFluently($this, 'admission_length', $value->format('H:i:s'));
    }

//    /** @param array{
//     *     id: string,
//     *     title: string,
//     *     admission_length: string
//     * } $originalDataArray
//     */
}
