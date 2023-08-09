<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\UserPosition;

use DateInterval;
use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\UserPosition\UserPositionOnlyDto;
use VetmanagerApiGateway\DTO\UserPosition\UserPositionOnlyDtoInterface;

///**
// * @property-read UserPositionOnlyDto $originalDto
// * @property int $id
// * @property string $title
// * @property ?DateInterval $admissionLength Default: '00:30:00'
// * @property-read array{
// *     id: string,
// *     title: string,
// *     admission_length: string
// * } $originalDataArray
// */
final class UserPosition extends AbstractActiveRecord implements UserPositionOnlyDtoInterface
{
    public static function getRouteKey(): string
    {
        return 'userPosition';
    }

    public static function getDtoClass(): string
    {
        return UserPositionOnlyDto::class;
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, UserPositionOnlyDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    /** @inheritDoc */
    public function getId(): int
    {
        return $this->modelDTO->getId();
    }

    public function getTitle(): ?string
    {
        return $this->modelDTO->getTitle();
    }

    /** @inheritDoc */
    public function getAdmissionLengthAsString(): ?string
    {
        return $this->modelDTO->getAdmissionLengthAsString();
    }

    /** @inheritDoc */
    public function getAdmissionLengthAsDateInterval(): ?DateInterval
    {
        return $this->modelDTO->getAdmissionLengthAsDateInterval();
    }

    /** @inheritDoc */
    public function setId(int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setId($value));
    }

    /** @inheritDoc */
    public function setTitle(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setTitle($value));
    }

    /** @inheritDoc */
    public function setAdmissionLengthFromString(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setAdmissionLengthFromString($value));
    }

    /** @inheritDoc */
    public function setAdmissionLengthFromDateInterval(DateInterval $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setAdmissionLengthFromDateInterval($value));
    }
}
