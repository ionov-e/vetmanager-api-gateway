<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\CassaClose;

use DateTime;
use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecord\Cassa\Cassa;
use VetmanagerApiGateway\ActiveRecord\CreatableInterface;
use VetmanagerApiGateway\ActiveRecord\DeletableInterface;
use VetmanagerApiGateway\ActiveRecord\User\UserPlusPositionAndRole;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\CassaClose\CassaCloseOnlyDto;
use VetmanagerApiGateway\DTO\CassaClose\CassaCloseOnlyDtoInterface;
use VetmanagerApiGateway\DTO\Payment\StatusEnum;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade;

abstract class AbstractCassaClose extends AbstractActiveRecord implements CassaCloseOnlyDtoInterface, CreatableInterface, DeletableInterface
{
    public function __construct(ActiveRecordFactory $activeRecordFactory, CassaCloseOnlyDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    public static function getDtoClass(): string
    {
        return CassaCloseOnlyDto::class;
    }

    public static function getRouteKey(): string
    {
        return 'cassaclose';
    }

    /** @throws VetmanagerApiGatewayException */
    public function create(): self
    {
        return (new Facade\CassaClose($this->activeRecordFactory))->createNewUsingArray($this->getAsArrayWithSetPropertiesOnly());
    }

    /** @throws VetmanagerApiGatewayException */
    public function update(): self
    {
        return (new Facade\CassaClose($this->activeRecordFactory))->updateUsingIdAndArray($this->getId(), $this->getAsArrayWithSetPropertiesOnly());
    }

    /** @throws VetmanagerApiGatewayException */
    public function delete(): void
    {
        (new Facade\CassaClose($this->activeRecordFactory))->delete($this->getId());
    }

    /**
     * @inheritDoc
     */
    public function getId(): int
    {
        return $this->modelDTO->getId();
    }

    /**
     * @inheritDoc
     */
    public function getDateAsString(): string
    {
        return $this->modelDTO->getDateAsString();
    }

    /**
     * @inheritDoc
     */
    public function getDateAsDateTime(): DateTime
    {
        return $this->modelDTO->getDateAsDateTime();
    }

    /**
     * @inheritDoc
     */
    public function getCassaId(): int
    {
        return $this->modelDTO->getCassaId();
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
    public function getClosedUserId(): int
    {
        return $this->modelDTO->getClosedUserId();
    }

    public function getAmount(): float
    {
        return $this->modelDTO->getAmount();
    }

    /**
     * @inheritDoc
     */
    public function getAmountCashless(): float
    {
        return $this->modelDTO->getAmountCashless();
    }

    /**
     * @inheritDoc
     */
    public function setDateFromString(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setDateFromString($value));
    }

    /**
     * @inheritDoc
     */
    public function setDateFromDateTime(DateTime $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setDateFromDateTime($value));
    }

    /**
     * @inheritDoc
     */
    public function setCassaId(int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setCassaId($value));
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
    public function setClosedUserId(int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setClosedUserId($value));
    }

    /**
     * @inheritDoc
     */
    public function setAmount(?float $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setAmount($value));
    }

    /**
     * @inheritDoc
     */
    public function setAmountCashless(float $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setAmountCashless($value));
    }

    /**
     * @throws VetmanagerApiGatewayException
     */
    public function getCassa(): Cassa
    {
        return (new Facade\Cassa($this->activeRecordFactory))->getById($this->getCassaId());
    }

    /**
     * @throws VetmanagerApiGatewayException
     */
    public function getClosedUser(): UserPlusPositionAndRole
    {
        return (new Facade\User($this->activeRecordFactory))->getById($this->getClosedUserId());
    }
}
