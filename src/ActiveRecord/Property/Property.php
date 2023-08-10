<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Property;

use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecord\Clinic\Clinic;
use VetmanagerApiGateway\ActiveRecord\CreatableInterface;
use VetmanagerApiGateway\ActiveRecord\DeletableInterface;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\Property\PropertyOnlyDto;
use VetmanagerApiGateway\DTO\Property\PropertyOnlyDtoInterface;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade;

///**
// * @property-read PropertyOnlyDto $originalDto
// * @property positive-int $id
// * @property string $name Default: ''
// * @property string $value
// * @property ?string $title
// * @property ?positive-int $clinicId
// * @property-read array{
// *     id: string,
// *     property_name: string,
// *     property_value: string,
// *     property_title: ?string,
// *     clinic_id: string
// * } $originalDataArray
// * @property-read ?Clinic $clinic
// * @property-read ?bool $isOnlineSigningUpAvailableForClinic null возвращается, если вдруг clinic_id = null
// */
final class Property extends AbstractActiveRecord implements PropertyOnlyDtoInterface, CreatableInterface, DeletableInterface
{
    public static function getRouteKey(): string
    {
        return 'properties';
    }

    public static function getDtoClass(): string
    {
        return PropertyOnlyDto::class;
    }

    /** @throws VetmanagerApiGatewayException */
    public function create(): self
    {
        return (new Facade\Property($this->activeRecordFactory))->createNewUsingArray($this->getAsArray());
    }

    /** @throws VetmanagerApiGatewayException */
    public function update(): self
    {
        return (new Facade\Property($this->activeRecordFactory))->updateUsingIdAndArray($this->getId(), $this->getAsArrayWithSetPropertiesOnly());
    }

    /** @throws VetmanagerApiGatewayException */
    public function delete(): void
    {
        (new Facade\Property($this->activeRecordFactory))->delete($this->getId());
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, PropertyOnlyDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    /** @inheritDoc */
    public function getId(): int
    {
        return $this->modelDTO->getId();
    }

    /** @inheritDoc */
    public function getName(): ?string
    {
        return $this->modelDTO->getName();
    }

    public function getValue(): ?string
    {
        return $this->modelDTO->getValue();
    }

    public function getTitle(): ?string
    {
        return $this->modelDTO->getTitle();
    }

    /** @inheritDoc */
    public function getClinicId(): ?int
    {
        return $this->modelDTO->getClinicId();
    }

    /** @inheritDoc */
    public function setName(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setName($value));
    }

    /** @inheritDoc */
    public function setValue(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setValue($value));
    }

    /** @inheritDoc */
    public function setTitle(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setTitle($value));
    }

    /** @inheritDoc */
    public function setClinicId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setClinicId($value));
    }

    /** @throws VetmanagerApiGatewayException */
    public function getClinic(): Clinic
    {
        return (new \VetmanagerApiGateway\Facade\Clinic($this->activeRecordFactory))->getById($this->getClinicId());
    }

    /** @throws VetmanagerApiGatewayException */
    public function isOnlineSigningUpAvailableForClinic(): bool
    {
        return (new \VetmanagerApiGateway\Facade\Property($this->activeRecordFactory))->getIsOnlineSigningUpAvailableForClinic($this->getClinicId());
    }
}
