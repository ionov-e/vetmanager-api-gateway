<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Cassa;

use DateTime;
use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecord\Clinic\Clinic;
use VetmanagerApiGateway\ActiveRecord\CreatableInterface;
use VetmanagerApiGateway\ActiveRecord\DeletableInterface;
use VetmanagerApiGateway\ActiveRecord\User\UserPlusPositionAndRole;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\Cassa\CassaOnlyDto;
use VetmanagerApiGateway\DTO\Cassa\CassaOnlyDtoInterface;
use VetmanagerApiGateway\DTO\Cassa\TypeEnum;
use VetmanagerApiGateway\DTO\Payment\StatusEnum;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;
use VetmanagerApiGateway\Facade;

final class Cassa extends AbstractActiveRecord implements CassaOnlyDtoInterface, CreatableInterface, DeletableInterface
{
    public function __construct(ActiveRecordFactory $activeRecordFactory, CassaOnlyDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    public static function getDtoClass(): string
    {
        return CassaOnlyDto::class;
    }

    public static function getRouteKey(): string
    {
        return 'cassa';
    }

    /** @throws VetmanagerApiGatewayException */
    public function create(): self
    {
        return (new Facade\Cassa($this->activeRecordFactory))->createNewUsingArray($this->getAsArrayWithSetPropertiesOnly());
    }

    /** @throws VetmanagerApiGatewayException */
    public function update(): self
    {
        return (new Facade\Cassa($this->activeRecordFactory))->updateUsingIdAndArray($this->getId(), $this->getAsArrayWithSetPropertiesOnly());
    }

    /** @throws VetmanagerApiGatewayException */
    public function delete(): void
    {
        (new Facade\Cassa($this->activeRecordFactory))->delete($this->getId());
    }

    /**
     * @inheritDoc
     */
    public function getId(): int
    {
        return $this->modelDTO->getId();
    }

    public function getTitle(): string
    {
        return $this->modelDTO->getTitle();
    }

    /**
     * @inheritDoc
     */
    public function getAssignedUserId(): int
    {
        return $this->modelDTO->getAssignedUserId();
    }

    /**
     * @inheritDoc
     */
    public function getInventarizationDateAsString(): string
    {
        return $this->modelDTO->getInventarizationDateAsString();
    }

    /**
     * @inheritDoc
     */
    public function getInventarizationDateAsDateTime(): DateTime
    {
        return $this->modelDTO->getInventarizationDateAsDateTime();
    }

    /**
     * @inheritDoc
     */
    public function getIsClientCassa(): ?bool
    {
        return $this->modelDTO->getIsClientCassa();
    }

    /**
     * @inheritDoc
     */
    public function getIsMainCassa(): bool
    {
        return $this->modelDTO->getIsMainCassa();
    }

    /**
     * @inheritDoc
     */
    public function getIsBlocked(): bool
    {
        return $this->modelDTO->getIsBlocked();
    }

    /**
     * @inheritDoc
     */
    public function getHasUnfinishedDocs(): bool
    {
        return $this->modelDTO->getHasUnfinishedDocs();
    }

    /**
     * @inheritDoc
     */
    public function getStatusAsString(): string
    {
        return $this->modelDTO->getStatusAsString();
    }

    public function getStatusAsEnum(): StatusEnum
    {
        return $this->modelDTO->getStatusAsEnum();
    }

    /**
     * @inheritDoc
     */
    public function getClinicId(): int
    {
        return $this->modelDTO->getClinicId();
    }

    public function getSummaCash(): float
    {
        return $this->modelDTO->getSummaCash();
    }

    public function getSummaCashless(): float
    {
        return $this->modelDTO->getSummaCashless();
    }

    /**
     * @inheritDoc
     */
    public function getIsSystem(): bool
    {
        return $this->modelDTO->getIsSystem();
    }

    /**
     * @inheritDoc
     */
    public function getShowInCashFlow(): bool
    {
        return $this->modelDTO->getShowInCashFlow();
    }

    /**
     * @inheritDoc
     */
    public function getTypeAsString(): string
    {
        return $this->modelDTO->getTypeAsString();
    }

    public function getTypeAsEnum(): TypeEnum
    {
        return $this->modelDTO->getTypeAsEnum();
    }

    /**
     * @inheritDoc
     */
    public function getCashlessToCassaId(): int
    {
        return $this->modelDTO->getCashlessToCassaId();
    }

    /**
     * @inheritDoc
     */
    public function setTitle(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setTitle($value));
    }

    /**
     * @inheritDoc
     */
    public function setAssignedUserId(int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setAssignedUserId($value));
    }

    /**
     * @inheritDoc
     */
    public function setInventarizationDateFromString(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setInventarizationDateFromString($value));
    }

    /**
     * @inheritDoc
     */
    public function setInventarizationDateFromDateTime(DateTime $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setInventarizationDateFromDateTime($value));
    }

    /**
     * @inheritDoc
     */
    public function setIsClientCassa(?bool $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setIsClientCassa($value));
    }

    /**
     * @inheritDoc
     */
    public function setMainCassa(bool $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setMainCassa($value));
    }

    /**
     * @inheritDoc
     */
    public function setIsBlocked(bool $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setIsBlocked($value));
    }

    /**
     * @inheritDoc
     */
    public function setHasUnfinishedDocs(bool $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setHasUnfinishedDocs($value));
    }

    /**
     * @inheritDoc
     */
    public function setStatusFromEnum(StatusEnum $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setStatusFromEnum($value));
    }

    /**
     * @inheritDoc
     */
    public function setStatusFromString(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setStatusFromString($value));
    }

    /**
     * @inheritDoc
     */
    public function setClinicId(int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setClinicId($value));
    }

    /**
     * @inheritDoc
     */
    public function setSummaCash(float $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setSummaCash($value));
    }

    /**
     * @inheritDoc
     */
    public function setSummaCashless(float $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setSummaCashless($value));
    }

    /**
     * @inheritDoc
     */
    public function setIsSystem(bool $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setIsSystem($value));
    }

    /**
     * @inheritDoc
     */
    public function setShowInCashFlow(bool $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setShowInCashFlow($value));
    }

    /**
     * @inheritDoc
     */
    public function setTypeFromEnum(TypeEnum $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setTypeFromEnum($value));
    }

    /**
     * @inheritDoc
     */
    public function setTypeFromString(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setTypeFromString($value));
    }

    /**
     * @inheritDoc
     */
    public function setCashlessToCassaId(int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setCashlessToCassaId($value));
    }

    /**
     * @throws VetmanagerApiGatewayResponseException
     * @throws VetmanagerApiGatewayException
     */
    public function getClinic(): Clinic
    {
        return (new Facade\Clinic($this->activeRecordFactory))->getById($this->getClinicId());
    }

    /**
     * @throws VetmanagerApiGatewayException
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getAssignedUser(): UserPlusPositionAndRole
    {
        return (new Facade\User($this->activeRecordFactory))->getById($this->getAssignedUserId());
    }
}
