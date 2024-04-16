<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Payment;

use DateTime;
use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecord\Cassa\Cassa;
use VetmanagerApiGateway\ActiveRecord\CassaClose\AbstractCassaClose;
use VetmanagerApiGateway\ActiveRecord\CreatableInterface;
use VetmanagerApiGateway\ActiveRecord\DeletableInterface;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\Payment\PaymentEnum;
use VetmanagerApiGateway\DTO\Payment\PaymentOnlyDto;
use VetmanagerApiGateway\DTO\Payment\PaymentOnlyDtoInterface;
use VetmanagerApiGateway\DTO\Payment\StatusEnum;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;
use VetmanagerApiGateway\Facade;

abstract class AbstractPayment extends AbstractActiveRecord implements PaymentOnlyDtoInterface, CreatableInterface, DeletableInterface
{
    public static function getRouteKey(): string
    {
        return 'payment';
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, PaymentOnlyDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    /** @throws VetmanagerApiGatewayException */
    public function create(): self
    {
        return (new Facade\Payment($this->activeRecordFactory))->createNewUsingArray($this->getAsArrayWithSetPropertiesOnly());
    }

    /** @throws VetmanagerApiGatewayException */
    public function update(): self
    {
        return (new Facade\Payment($this->activeRecordFactory))->updateUsingIdAndArray($this->getId(), $this->getAsArrayWithSetPropertiesOnly());
    }

    /** @throws VetmanagerApiGatewayException */
    public function delete(): void
    {
        (new Facade\Payment($this->activeRecordFactory))->delete($this->getId());
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
    public function getAmount(): float
    {
        return $this->modelDTO->getAmount();
    }

    /**
     * @inheritDoc
     */
    public function getStatusAsString(): ?string
    {
        return $this->modelDTO->getStatusAsString();
    }

    /**
     * @inheritDoc
     */
    public function getStatusAsEnum(): ?StatusEnum
    {
        return $this->modelDTO->getStatusAsEnum();
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
    public function getCassaCloseId(): int|null
    {
        return $this->modelDTO->getCassaCloseId();
    }

    /**
     * @inheritDoc
     */
    public function getCreateDateAsString(): string
    {
        return $this->modelDTO->getCreateDateAsString();
    }

    /**
     * @inheritDoc
     */
    public function getCreateDateAsDateTime(): DateTime
    {
        return $this->modelDTO->getCreateDateAsDateTime();
    }

    /**
     * @inheritDoc
     */
    public function getPayedUserId(): int
    {
        return $this->modelDTO->getPayedUserId();
    }

    public function getDescription(): string
    {
        return $this->modelDTO->getDescription();
    }

    /**
     * @inheritDoc
     */
    public function getPaymentTypeAsString(): string
    {
        return $this->modelDTO->getPaymentTypeAsString();
    }

    public function getPaymentTypeAsEnum(): PaymentEnum
    {
        return $this->modelDTO->getPaymentTypeAsEnum();
    }

    /**
     * @inheritDoc
     */
    public function getInvoiceId(): int|null
    {
        return $this->modelDTO->getInvoiceId();
    }

    /**
     * @inheritDoc
     */
    public function getParentId(): int|null
    {
        return $this->modelDTO->getParentId();
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
    public function setStatusFromString(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setStatusFromString($value));
    }

    /**
     * @inheritDoc
     */
    public function setStatusFromEnum(?StatusEnum $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setStatusFromEnum($value));
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
    public function setCassaCloseId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setCassaCloseId($value));
    }

    /**
     * @inheritDoc
     */
    public function setCreateDateFromString(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setCreateDateFromString($value));
    }

    /**
     * @inheritDoc
     */
    public function setCreateDateFromDateTime(DateTime $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setCreateDateFromDateTime($value));
    }

    /**
     * @inheritDoc
     */
    public function setPayedUserId(int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setPayedUserId($value));
    }

    /**
     * @inheritDoc
     */
    public function setDescription(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setDescription($value));
    }

    /**
     * @inheritDoc
     */
    public function setPaymentTypeFromString(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setPaymentTypeFromString($value));
    }

    /**
     * @inheritDoc
     */
    public function setPaymentTypeFromEnum(?PaymentEnum $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setPaymentTypeFromEnum($value));
    }

    /**
     * @inheritDoc
     */
    public function setInvoiceId(int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setInvoiceId($value));
    }

    /**
     * @inheritDoc
     */
    public function setParentId(int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setParentId($value));
    }

    abstract public function getCassa(): Cassa;

    abstract public function getCassaClose(): ?AbstractCassaClose;

    /**
     * @throws VetmanagerApiGatewayResponseException
     * @throws VetmanagerApiGatewayException
     */
    public function getParentPayment(): ?PaymentPlusCassaAndCassaClose
    {
        return $this->getParentId()
            ? (new Facade\Payment($this->activeRecordFactory))->getById($this->getParentId())
            : null;
    }
}
