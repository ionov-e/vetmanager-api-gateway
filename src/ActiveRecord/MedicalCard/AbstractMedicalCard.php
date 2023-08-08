<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\MedicalCard;

use DateTime;
use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecord\Admission\AbstractAdmission;
use VetmanagerApiGateway\ActiveRecord\Clinic\Clinic;
use VetmanagerApiGateway\ActiveRecord\ComboManualItem\AbstractComboManualItem;
use VetmanagerApiGateway\ActiveRecord\Invoice\AbstractInvoice;
use VetmanagerApiGateway\ActiveRecord\Pet\AbstractPet;
use VetmanagerApiGateway\ActiveRecord\User\AbstractUser;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\MedicalCard\MedicalCardOnlyDto;
use VetmanagerApiGateway\DTO\MedicalCard\MedicalCardOnlyDtoInterface;
use VetmanagerApiGateway\DTO\MedicalCard\StatusEnum;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade;

abstract class AbstractMedicalCard extends AbstractActiveRecord implements MedicalCardOnlyDtoInterface
{
    public static function getRouteKey(): string
    {
        return 'medicalCards';
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, MedicalCardOnlyDto $modelDTO)
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
    public function getPetId(): int
    {
        return $this->modelDTO->getPetId();
    }

    /** @inheritDoc */
    public function getDateCreateAsString(): string
    {
        return $this->modelDTO->getDateCreateAsString();
    }

    /** @inheritDoc */
    public function getDateCreateAsDateTime(): DateTime
    {
        return $this->modelDTO->getDateCreateAsDateTime();
    }

    /** @inheritDoc */
    public function getDateEditAsString(): string
    {
        return $this->modelDTO->getDateEditAsString();
    }

    /** @inheritDoc */
    public function getDateEditAsDateTime(): DateTime
    {
        return $this->modelDTO->getDateEditAsDateTime();
    }

    /** @inheritDoc */
    public function getDiagnose(): string
    {
        return $this->modelDTO->getDiagnose();
    }

    /** @inheritDoc */
    public function getRecommendation(): string
    {
        return $this->modelDTO->getRecommendation();
    }

    /** @inheritDoc */
    public function getInvoiceId(): ?int
    {
        return $this->modelDTO->getInvoiceId();
    }

    /** @inheritDoc */
    public function getAdmissionTypeId(): ?int
    {
        return $this->modelDTO->getAdmissionTypeId();
    }

    /** @inheritDoc */
    public function getWeight(): ?float
    {
        return $this->modelDTO->getWeight();
    }

    /** @inheritDoc */
    public function getTemperature(): ?float
    {
        return $this->modelDTO->getTemperature();
    }

    /** @inheritDoc */
    public function getMeetResultId(): ?int
    {
        return $this->modelDTO->getMeetResultId();
    }

    /** @inheritDoc */
    public function getDescription(): string
    {
        return $this->modelDTO->getDescription();
    }

    /** @inheritDoc */
    public function getNextMeetId(): ?int
    {
        return $this->modelDTO->getNextMeetId();
    }

    /** @inheritDoc */
    public function getUserId(): ?int
    {
        return $this->modelDTO->getUserId();
    }

    /** @inheritDoc */
    public function getCreatorId(): ?int
    {
        return $this->modelDTO->getCreatorId();
    }

    /** @inheritDoc */
    public function getStatusAsString(): string
    {
        return $this->modelDTO->getStatusAsString();
    }

    /** @inheritDoc */
    public function getStatusAsEnum(): StatusEnum
    {
        return $this->modelDTO->getStatusAsEnum();
    }

    /** @inheritDoc */
    public function getCallingId(): ?int
    {
        return $this->modelDTO->getCallingId();
    }

    /** @inheritDoc */
    public function getAdmissionId(): ?int
    {
        return $this->modelDTO->getAdmissionId();
    }

    /** @inheritDoc */
    public function getDiagnoseText(): string
    {
        return $this->modelDTO->getDiagnoseText();
    }

    /** @inheritDoc */
    public function getDiagnoseTypeText(): string
    {
        return $this->modelDTO->getDiagnoseTypeText();
    }

    /** @inheritDoc */
    public function getClinicId(): ?int
    {
        return $this->modelDTO->getClinicId();
    }

    /** @inheritDoc */
    public function setId(int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setId($value));
    }

    /** @inheritDoc */
    public function setPetId(int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setPetId($value));
    }

    /** @inheritDoc */
    public function setDateCreateAsString(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setDateCreateAsString($value));
    }

    /** @inheritDoc */
    public function setDateCreateAsDateTime(DateTime $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setDateCreateAsDateTime($value));
    }

    /** @inheritDoc */
    public function setDateEditAsString(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setDateEditAsString($value));
    }

    /** @inheritDoc */
    public function setDateEditAsDateTime(DateTime $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setDateEditAsDateTime($value));
    }

    /** @inheritDoc */
    public function setDiagnose(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setDiagnose($value));
    }

    /** @inheritDoc */
    public function setRecommendation(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setRecommendation($value));
    }

    /** @inheritDoc */
    public function setInvoiceId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setInvoiceId($value));
    }

    /** @inheritDoc */
    public function setAdmissionTypeId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setAdmissionTypeId($value));
    }

    /** @inheritDoc */
    public function setWeight(?float $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setWeight($value));
    }

    /** @inheritDoc */
    public function setTemperature(?float $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setTemperature($value));
    }

    /** @inheritDoc */
    public function setMeetResultId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setMeetResultId($value));
    }

    /** @inheritDoc */
    public function setDescription(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setDescription($value));
    }

    /** @inheritDoc */
    public function setNextMeetId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setNextMeetId($value));
    }

    /** @inheritDoc */
    public function setUserId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setUserId($value));
    }

    /** @inheritDoc */
    public function setCreatorId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setCreatorId($value));
    }

    /** @inheritDoc */
    public function setStatusAsString(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setStatusAsString($value));
    }

    /** @inheritDoc */
    public function setStatusAsEnum(StatusEnum $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setStatusAsEnum($value));
    }

    /** @inheritDoc */
    public function setCallingId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setCallingId($value));
    }

    /** @inheritDoc */
    public function setAdmissionId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setAdmissionId($value));
    }

    /** @inheritDoc */
    public function setDiagnoseText(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setDiagnoseText($value));
    }

    /** @inheritDoc */
    public function setDiagnoseTypeText(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setDiagnoseTypeText($value));
    }

    /** @inheritDoc */
    public function setClinicId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setClinicId($value));
    }

    abstract public function getPet(): AbstractPet;

    /** @throws VetmanagerApiGatewayException */
    public function getClinic(): ?Clinic
    {
        return $this->getClinicId()
            ? (new Facade\Clinic($this->activeRecordFactory))->getById($this->getClinicId())
            : null;
    }

    /** @throws VetmanagerApiGatewayException */
    public function isOnlineSigningUpAvailableForClinic(): ?bool
    {
        return $this->getClinicId()
            ? (new Facade\Property($this->activeRecordFactory))->isOnlineSigningUpAvailableForClinic($this->getClinicId())
            : null;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getAdmission(): ?AbstractAdmission
    {
        return $this->getAdmissionId()
            ? (new Facade\Admission($this->activeRecordFactory))->getById($this->getAdmissionId())
            : null;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getNextMeet(): ?AbstractAdmission
    {
        return $this->getNextMeetId()
            ? (new Facade\Admission($this->activeRecordFactory))->getById($this->getNextMeetId())
            : null;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getAdmissionType(): ?AbstractComboManualItem
    {
        return $this->getAdmissionTypeId()
            ? (new Facade\ComboManualItem($this->activeRecordFactory))->getByAdmissionTypeId($this->getAdmissionTypeId())
            : null;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getMeetResult(): ?AbstractComboManualItem
    {
        return $this->getMeetResultId()
            ? (new Facade\ComboManualItem($this->activeRecordFactory))->getByAdmissionResultId($this->getMeetResultId())
            : null;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getInvoice(): ?AbstractInvoice
    {
        return $this->getInvoiceId()
            ? (new Facade\Invoice($this->activeRecordFactory))->getById($this->getInvoiceId())
            : null;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getUser(): ?AbstractUser
    {
        return $this->getUserId()
            ? (new Facade\User($this->activeRecordFactory))->getById($this->getUserId())
            : null;
    }
}
