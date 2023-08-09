<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Invoice;

use DateTime;
use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecord\Breed\AbstractBreed;
use VetmanagerApiGateway\ActiveRecord\Client\AbstractClient;
use VetmanagerApiGateway\ActiveRecord\InvoiceDocument\AbstractInvoiceDocument;
use VetmanagerApiGateway\ActiveRecord\Pet\AbstractPet;
use VetmanagerApiGateway\ActiveRecord\PetType\AbstractPetType;
use VetmanagerApiGateway\ActiveRecord\User\AbstractUser;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\Invoice\InvoiceOnlyDto;
use VetmanagerApiGateway\DTO\Invoice\InvoiceOnlyDtoInterface;
use VetmanagerApiGateway\DTO\Invoice\PaymentStatusEnum;
use VetmanagerApiGateway\DTO\Invoice\StatusEnum;

abstract class AbstractInvoice extends AbstractActiveRecord implements InvoiceOnlyDtoInterface
{
    public static function getRouteKey(): string
    {
        return 'invoice';
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, InvoiceOnlyDto $modelDTO)
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
    public function getUserId(): ?int
    {
        return $this->modelDTO->getUserId();
    }

    /** @inheritDoc */
    public function getClientId(): int
    {
        return $this->modelDTO->getClientId();
    }

    /** @inheritDoc */
    public function getPetId(): int
    {
        return $this->modelDTO->getPetId();
    }

    public function getDescription(): ?string
    {
        return $this->modelDTO->getDescription();
    }

    /** @inheritDoc */
    public function getPercent(): ?float
    {
        return $this->modelDTO->getPercent();
    }

    /** @inheritDoc */
    public function getAmount(): ?float
    {
        return $this->modelDTO->getAmount();
    }

    /** @inheritDoc */
    public function getStatusAsString(): string
    {
        return $this->modelDTO->getStatusAsString();
    }

    public function getStatusAsEnum(): \VetmanagerApiGateway\DTO\Invoice\StatusEnum
    {
        return $this->modelDTO->getStatusAsEnum();
    }

    /** @inheritDoc */
    public function getInvoiceDateAsString(): string
    {
        return $this->modelDTO->getInvoiceDateAsString();
    }

    /** @inheritDoc */
    public function getInvoiceDateAsDateTime(): DateTime
    {
        return $this->modelDTO->getInvoiceDateAsDateTime();
    }

    /** @inheritDoc */
    public function getOldId(): ?int
    {
        return $this->modelDTO->getOldId();
    }

    /** @inheritDoc */
    public function getNight(): ?int
    {
        return $this->modelDTO->getNight();
    }

    /** @inheritDoc */
    public function getIncrease(): float
    {
        return $this->modelDTO->getIncrease();
    }

    /** @inheritDoc */
    public function getDiscount(): float
    {
        return $this->modelDTO->getDiscount();
    }

    /** @inheritDoc */
    public function getCallId(): ?int
    {
        return $this->modelDTO->getCallId();
    }

    /** @inheritDoc */
    public function getPaidAmount(): float
    {
        return $this->modelDTO->getPaidAmount();
    }

    /** @inheritDoc */
    public function getCreateDateAsString(): string
    {
        return $this->modelDTO->getCreateDateAsString();
    }

    /** @inheritDoc */
    public function getCreateDateAsDateTime(): DateTime
    {
        return $this->modelDTO->getCreateDateAsDateTime();
    }

    /** @inheritDoc */
    public function getPaymentStatusAsString(): string
    {
        return $this->modelDTO->getPaymentStatusAsString();
    }

    /** @inheritDoc */
    public function getPaymentStatusAsEnum(): PaymentStatusEnum
    {
        return $this->modelDTO->getPaymentStatusAsEnum();
    }

    /** @inheritDoc */
    public function getClinicId(): ?int
    {
        return $this->modelDTO->getClinicId();
    }

    /** @inheritDoc */
    public function getCreatorId(): ?int
    {
        return $this->modelDTO->getCreatorId();
    }

    /** @inheritDoc */
    public function getFiscalSectionId(): ?int
    {
        return $this->modelDTO->getFiscalSectionId();
    }

    /** @inheritDoc */
    public function setId(int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setId($value));
    }

    /** @inheritDoc */
    public function setUserId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setUserId($value));
    }

    /** @inheritDoc */
    public function setClientId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setClientId($value));
    }

    /** @inheritDoc */
    public function setPetId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setPetId($value));
    }

    /** @inheritDoc */
    public function setDescription(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setDescription($value));
    }

    /** @inheritDoc */
    public function setPercent(?float $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setPercent($value));
    }

    /** @inheritDoc */
    public function setAmount(?float $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setAmount($value));
    }

    /** @inheritDoc */
    public function setStatusAsString(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setStatusAsString($value));
    }

    public function setStatusAsEnum(StatusEnum $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setStatusAsEnum($value));
    }

    /** @inheritDoc */
    public function setInvoiceDateAsString(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setInvoiceDateAsString($value));
    }

    /** @inheritDoc */
    public function setInvoiceDateAsDateTime(DateTime $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setInvoiceDateAsDateTime($value));
    }

    /** @inheritDoc */
    public function setOldId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setOldId($value));
    }

    /** @inheritDoc */
    public function setNight(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setNight($value));
    }

    /** @inheritDoc */
    public function setIncrease(?float $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setIncrease($value));
    }

    /** @inheritDoc */
    public function setDiscount(?float $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setDiscount($value));
    }

    /** @inheritDoc */
    public function setCallId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setCallId($value));
    }

    /** @inheritDoc */
    public function setPaidAmount(?float $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setPaidAmount($value));
    }

    /** @inheritDoc */
    public function setCreateDateAsString(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setCreateDateAsString($value));
    }

    /** @inheritDoc */
    public function setCreateDateAsDateTime(DateTime $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setCreateDateAsDateTime($value));
    }

    /** @inheritDoc */
    public function setPaymentStatusAsString(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setPaymentStatusAsString($value));
    }

    /** @inheritDoc */
    public function setPaymentStatusAsEnum(PaymentStatusEnum $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setPaymentStatusAsEnum($value));
    }

    /** @inheritDoc */
    public function setClinicId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setClinicId($value));
    }

    /** @inheritDoc */
    public function setCreatorId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setCreatorId($value));
    }

    /** @inheritDoc */
    public function setFiscalSectionId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setFiscalSectionId($value));
    }

    abstract public function getClient(): AbstractClient;

    abstract public function getPet(): AbstractPet;

    abstract public function getPetBreed(): ?AbstractBreed;

    abstract public function getPetType(): ?AbstractPetType;

    abstract public function getUser(): AbstractUser;

    /** @return AbstractInvoiceDocument[] */
    abstract public function getInvoiceDocuments(): array;
}
