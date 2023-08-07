<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\MedicalCardByClient;

use DateTime;
use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecord\Client\ClientPlusTypeAndCity;
use VetmanagerApiGateway\ActiveRecord\ComboManualItem\AbstractComboManualItem;
use VetmanagerApiGateway\ActiveRecord\Pet\PetPlusOwnerAndTypeAndBreedAndColor;
use VetmanagerApiGateway\ActiveRecord\User\UserPlusPositionAndRole;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\MedicalCardByClient\MedicalCardByClientDto;
use VetmanagerApiGateway\DTO\MedicalCardByClient\MedicalCardByClientDtoInterface;
use VetmanagerApiGateway\DTO\Pet\SexEnum;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade;

///**
// * @property-read MedicalCardByClientDto $originalDto
// * @property int $id
// * @property ?DateTime $dateEdit
// * @property string $diagnose Либо пустая строка, либо JSON типа: "[ {"id":32,"type":1}, {"id":35,"type":1}, {"id":77,"type":1} ]"
// * @property ?positive-int $userId
// * @property StatusEnum $status Default: 'active'
// * @property string $description Может быть просто строка, а может HTML-блок
// * @property string $recommendation Может прийти пустая строка, может просто строка, может HTML
// * @property ?float $weight
// * @property ?float $temperature
// * @property ?positive-int $meetResultId LEFT JOIN combo_manual_items ci2 ON ci2.combo_manual_id = 2 AND ci2.value = m.meet_result_id. 0 переводим в null
// * @property ?positive-int $admissionTypeId {@see AbstractMedicalCard::admissionType} Тип приема. LEFT JOIN combo_manual_items ci ON ci.combo_manual_id = {$reasonId} AND ci.value = m.admission_type
// * @property positive-int $petId
// * @property string $petAlias
// * @property ?DateTime $petBirthday Дата без времени
// * @property SexEnum $petSex
// * @property string $petNote
// * @property string $petTypeTitle
// * @property string $petBreedTitle
// * @property ?positive-int $clientId Не уверен, что вообще можем получить null
// * @property FullName $ownerFullName
// * @property string $ownerPhone
// * @property string $userLogin
// * @property FullName $userFullName
// * @property bool $isEditable Будет False, если в таблице special_studies_medcard_data будет хоть одна запись с таким же medcard_id {@see self::id}
// * @property string $meetResultTitle Пример: "Повторный прием". В таблице combo_manual_items ищет кортеж с combo_manual_id = 2 и value = {@see self::meetResultId}. Из строки возвращается title
// * @property string $admissionTypeTitle Пример: "Вакцинация", "Хирургия", "Первичный" или "Вторичный". В таблице combo_manual_items ищет строку с id = {@see self::admissionType} и возвращает значение из столбца title.
// * @property-read array{
// *     medical_card_id: numeric-string,
// *     date_edit: ?string,
// *     diagnos: string,
// *     doctor_id: numeric-string,
// *     medical_card_status: string,
// *     healing_process: ?string,
// *     recomendation: string,
// *     weight: ?string,
// *     temperature: ?string,
// *     meet_result_id: numeric-string,
// *     admission_type: ?string,
// *     pet_id: numeric-string,
// *     alias: string,
// *     birthday: ?string,
// *     sex: string,
// *     note: string,
// *     pet_type: string,
// *     breed: string,
// *     client_id: numeric-string,
// *     first_name: string,
// *     last_name: string,
// *     middle_name: string,
// *     phone: string,
// *     doctor_nickname: string,
// *     doctor_first_name: string,
// *     doctor_last_name: string,
// *     doctor_middle_name: string,
// *     editable: string,
// *     meet_result_title: string,
// *     admission_type_title: string
// * } $originalDataArray
// * @property-read ?ComboManualItemOnly admissionType
// * @property-read ?ComboManualItemOnly meetResult
// * @property-read ?ClientOnly client
// * @property-read PetOnly pet
// * @property-read ?UserOnly user
// */
final class MedicalCardByClient extends AbstractActiveRecord implements MedicalCardByClientDtoInterface
{
    public static function getDtoClass(): string
    {
        return MedicalCardByClientDto::class;
    }

    public static function getRouteKey(): string
    {
        return 'medicalcards';
    }

    public static function getModelKeyInResponse(): string
    {
        return 'medicalCards/MedicalcardsDataByClient';
    }


    public function __construct(ActiveRecordFactory $activeRecordFactory, MedicalCardByClientDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    /** @inheritDoc */
    public function getId(): int
    {
        return $this->modelDTO->getId();
    }

    public function getDateEditAsString(): ?string
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
    public function getUserId(): ?int
    {
        return $this->modelDTO->getUserId();
    }

    /** @inheritDoc */
    public function getStatusAsString(): string
    {
        return $this->modelDTO->getStatusAsString();
    }

    /** @inheritDoc */
    public function getStatusAsEnum(): \VetmanagerApiGateway\DTO\MedicalCard\StatusEnum
    {
        return $this->modelDTO->getStatusAsEnum();
    }

    /** @inheritDoc */
    public function getDescription(): string
    {
        return $this->modelDTO->getDescription();
    }

    /** @inheritDoc */
    public function getRecommendation(): string
    {
        return $this->modelDTO->getRecommendation();
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
    public function getAdmissionTypeId(): ?int
    {
        return $this->modelDTO->getAdmissionTypeId();
    }

    /** @inheritDoc */
    public function getPetId(): int
    {
        return $this->modelDTO->getPetId();
    }

    public function getPetAlias(): string
    {
        return $this->modelDTO->getPetAlias();
    }

    /** @inheritDoc */
    public function getBirthdayAsString(): ?string
    {
        return $this->modelDTO->getBirthdayAsString();
    }

    /** @inheritDoc */
    public function getBirthdayAsDateTime(): ?DateTime
    {
        return $this->modelDTO->getBirthdayAsDateTime();
    }

    public function getSexAsString(): ?string
    {
        return $this->modelDTO->getSexAsString();
    }

    public function getSexAsEnum(): SexEnum
    {
        return $this->modelDTO->getSexAsEnum();
    }

    public function getPetNote(): string
    {
        return $this->modelDTO->getPetNote();
    }

    public function getPetTypeTitle(): string
    {
        return $this->modelDTO->getPetTypeTitle();
    }

    public function getBreedTitle(): string
    {
        return $this->modelDTO->getBreedTitle();
    }

    /** @inheritDoc */
    public function getClientId(): ?int
    {
        return $this->modelDTO->getClientId();
    }

    public function getFirstName(): string
    {
        return $this->modelDTO->getFirstName();
    }

    public function getLastName(): string
    {
        return $this->modelDTO->getLastName();
    }

    public function getMiddleName(): string
    {
        return $this->modelDTO->getMiddleName();
    }

    public function getOwnerPhone(): string
    {
        return $this->modelDTO->getOwnerPhone();
    }

    public function getUserLogin(): string
    {
        return $this->modelDTO->getUserLogin();
    }

    public function getUserFirstName(): string
    {
        return $this->modelDTO->getUserFirstName();
    }

    public function getUserLastName(): string
    {
        return $this->modelDTO->getUserLastName();
    }

    public function getUserMiddleName(): string
    {
        return $this->modelDTO->getUserMiddleName();
    }

    /** @inheritDoc */
    public function getIsEditable(): bool
    {
        return $this->modelDTO->getIsEditable();
    }

    /** @inheritDoc */
    public function getMeetResultTitle(): string
    {
        return $this->modelDTO->getMeetResultTitle();
    }

    /** @inheritDoc */
    public function getAdmissionTypeTitle(): string
    {
        return $this->modelDTO->getAdmissionTypeTitle();
    }

    /** @inheritDoc */
    public function setId(int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setId($value));
    }

    /** @inheritDoc */
    public function setDateEditAsString(?string $value): static
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
    public function setUserId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setUserId($value));
    }

    /** @inheritDoc */
    public function setStatusAsString(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setStatusAsString($value));
    }

    /** @inheritDoc */
    public function setStatusAsEnum(\VetmanagerApiGateway\DTO\MedicalCard\StatusEnum $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setStatusAsEnum($value));
    }

    /** @inheritDoc */
    public function setDescription(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setDescription($value));
    }

    /** @inheritDoc */
    public function setRecommendation(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setRecommendation($value));
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
    public function setAdmissionTypeId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setAdmissionTypeId($value));
    }

    /** @inheritDoc */
    public function setPetId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setPetId($value));
    }

    /** @inheritDoc */
    public function setPetAlias(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setPetAlias($value));
    }

    /** @inheritDoc */
    public function setBirthdayAsString(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setBirthdayAsString($value));
    }

    /** @inheritDoc */
    public function setBirthdayAsDateTime(DateTime $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setBirthdayAsDateTime($value));
    }

    /** @inheritDoc */
    public function setSexAsString(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setSexAsString($value));
    }

    /** @inheritDoc */
    public function setSexAsEnum(SexEnum $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setSexAsEnum($value));
    }

    /** @inheritDoc */
    public function setPetNote(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setPetNote($value));
    }

    /** @inheritDoc */
    public function setPetTypeTitle(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setPetTypeTitle($value));
    }

    /** @inheritDoc */
    public function setBreedTitle(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setBreedTitle($value));
    }

    /** @inheritDoc */
    public function setClientId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setClientId($value));
    }

    /** @inheritDoc */
    public function setFirstName(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setFirstName($value));
    }

    /** @inheritDoc */
    public function setLastName(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setLastName($value));
    }

    /** @inheritDoc */
    public function setMiddleName(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setMiddleName($value));
    }

    /** @inheritDoc */
    public function setOwnerPhone(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setOwnerPhone($value));
    }

    /** @inheritDoc */
    public function setUserLogin(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setUserLogin($value));
    }

    /** @inheritDoc */
    public function setUserFirstName(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setUserFirstName($value));
    }

    /** @inheritDoc */
    public function setUserLastName(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setUserLastName($value));
    }

    /** @inheritDoc */
    public function setUserMiddleName(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setUserMiddleName($value));
    }

    /** @inheritDoc */
    public function setIsEditable(?bool $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setIsEditable($value));
    }

    /** @inheritDoc */
    public function setMeetResultTitle(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setMeetResultTitle($value));
    }

    /** @inheritDoc */
    public function setAdmissionTypeTitle(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setAdmissionTypeTitle($value));
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
    public function getClient(): ?ClientPlusTypeAndCity
    {
        return $this->getClientId()
            ? (new Facade\Client($this->activeRecordFactory))->getById($this->getClientId())
            : null;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getPet(): PetPlusOwnerAndTypeAndBreedAndColor
    {
        return (new Facade\Pet($this->activeRecordFactory))->getById($this->getPetId());
    }

    /** @throws VetmanagerApiGatewayException */
    public function getUser(): ?UserPlusPositionAndRole
    {
        return $this->getClientId()
            ? (new Facade\User($this->activeRecordFactory))->getById($this->getUserId())
            : null;
    }
}
