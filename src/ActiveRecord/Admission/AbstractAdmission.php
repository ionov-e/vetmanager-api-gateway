<?php

namespace VetmanagerApiGateway\ActiveRecord\Admission;

use DateInterval;
use DateTime;
use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecord\Breed\AbstractBreed;
use VetmanagerApiGateway\ActiveRecord\Client\AbstractClient;
use VetmanagerApiGateway\ActiveRecord\Clinic\Clinic;
use VetmanagerApiGateway\ActiveRecord\ComboManualItem\AbstractComboManualItem;
use VetmanagerApiGateway\ActiveRecord\Invoice\InvoiceOnly;
use VetmanagerApiGateway\ActiveRecord\Pet\AbstractPet;
use VetmanagerApiGateway\ActiveRecord\PetType\AbstractPetType;
use VetmanagerApiGateway\ActiveRecord\User\AbstractUser;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\Admission\AdmissionOnlyDto;
use VetmanagerApiGateway\DTO\Admission\AdmissionOnlyDtoInterface;
use VetmanagerApiGateway\DTO\Admission\StatusEnum;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Facade;

///**
// * @property-read AdmissionOnlyDto $originalDto
// * @property positive-int $id
// * @property ?DateTime $date Пример "2020-12-31 17:51:18". Может быть: "0000-00-00 00:00:00" - переводится в null
// * @property string $description Примеры: "На основании медкарты", "Запись из модуля, к свободному доктору, по услуге Ампутация пальцев"
// * @property ?positive-int $clientId
// * @property ?positive-int $petId
// * @property ?positive-int $userId
// * @property ?positive-int $typeId
// * @property ?DateInterval $admissionLength Примеры: "00:15:00", "00:00:00" (последнее перевожу в null)
// * @property ?StatusEnum $status
// * @property ?positive-int $clinicId В БД встречается "0" - переводим в null
// * @property bool $isDirectDirection Насколько я понял, означает: 'Прием без планирования'
// * @property ?positive-int $creatorId
// * @property ?DateTime $createDate
// * @property ?int $escortId Тут судя по коду, можно привязать еще одного доктора, т.е. ID от {@see UserOnly}. Какой-то врач-помощник что ли. Кроме "0" другие значения искал - не нашел. Думаю передумали реализовывать
// * @property string $receptionWriteChannel Искал по всем БД: находил только "vetmanager" и "" или null (редко. Пустые перевожу в null)
// * @property bool $isAutoCreate
// * @property float $invoicesSum Default: 0.0000000000
// * @property-read array{
// *          id: numeric-string,
// *          admission_date: string,
// *          description: string,
// *          client_id: numeric-string,
// *          patient_id: numeric-string,
// *          user_id: numeric-string,
// *          type_id: numeric-string,
// *          admission_length: string,
// *          status: ?string,
// *          clinic_id: numeric-string,
// *          direct_direction: string,
// *          creator_id: numeric-string,
// *          create_date: string,
// *          escorter_id: ?numeric-string,
// *          reception_write_channel: ?string,
// *          is_auto_create: string,
// *          invoices_sum: string,
// *          client: array{
// *                      id: string,
// *                      address: string,
// *                      home_phone: string,
// *                      work_phone: string,
// *                      note: string,
// *                      type_id: ?string,
// *                      how_find: ?string,
// *                      balance: string,
// *                      email: string,
// *                      city: string,
// *                      city_id: ?string,
// *                      date_register: string,
// *                      cell_phone: string,
// *                      zip: string,
// *                      registration_index: ?string,
// *                      vip: string,
// *                      last_name: string,
// *                      first_name: string,
// *                      middle_name: string,
// *                      status: string,
// *                      discount: string,
// *                      passport_series: string,
// *                      lab_number: string,
// *                      street_id: string,
// *                      apartment: string,
// *                      unsubscribe: string,
// *                      in_blacklist: string,
// *                      last_visit_date: string,
// *                      number_of_journal: string,
// *                      phone_prefix: ?string
// *          },
// *          pet?: array{
// *                      id: string,
// *                      owner_id: ?string,
// *                      type_id: ?string,
// *                      alias: string,
// *                      sex: ?string,
// *                      date_register: string,
// *                      birthday: ?string,
// *                      note: string,
// *                      breed_id: ?string,
// *                      old_id: ?string,
// *                      color_id: ?string,
// *                      deathnote: ?string,
// *                      deathdate: ?string,
// *                      chip_number: string,
// *                      lab_number: string,
// *                      status: string,
// *                      picture: ?string,
// *                      weight: ?string,
// *                      edit_date: string,
// *                      pet_type_data?: array{}|array{
// *                              id: string,
// *                              title: string,
// *                              picture: string,
// *                              type: ?string
// *                      },
// *                      breed_data?: array{
// *                              id: string,
// *                              title: string,
// *                              pet_type_id: string
// *                      }
// *          },
// *          doctor_data?: array{
// *                      id: string,
// *                      last_name: string,
// *                      first_name: string,
// *                      middle_name: string,
// *                      login: string,
// *                      passwd: string,
// *                      position_id: ?string,
// *                      email: string,
// *                      phone: string,
// *                      cell_phone: string,
// *                      address: string,
// *                      role_id: ?string,
// *                      is_active: string,
// *                      calc_percents: string,
// *                      nickname: ?string,
// *                      last_change_pwd_date: string,
// *                      is_limited: string,
// *                      carrotquest_id: ?string,
// *                      sip_number: string,
// *                      user_inn: string
// *          },
// *          admission_type_data?: array{
// *                      id: string,
// *                      combo_manual_id: string,
// *                      title: string,
// *                      value: string,
// *                      dop_param1: string,
// *                      dop_param2: string,
// *                      dop_param3: string,
// *                      is_active: string
// *          },
// *          wait_time?: string,
// *          invoices?: array<int, array{
// *                              id: string,
// *                              doctor_id: ?string,
// *                              client_id: string,
// *                              pet_id: string,
// *                              description: string,
// *                              percent: ?string,
// *                              amount: ?string,
// *                              status: string,
// *                              invoice_date: string,
// *                              old_id: ?string,
// *                              night: string,
// *                              increase: ?string,
// *                              discount: ?string,
// *                              call: string,
// *                              paid_amount: string,
// *                              create_date: string,
// *                              payment_status: string,
// *                              clinic_id: string,
// *                              creator_id: ?string,
// *                              fiscal_section_id: string,
// *                              d: string
// *           }>
// *     } $originalDataArray Массив, полученный по ID отличается от Get All лишь наличием двух дополнительных DTO: 1) {@see self::type} из элемента admission_type_data; 2) {@see self::user} из элемента doctor_data
// * @property-read string $waitTime
// * @property-read ClientOnly $client
// * @property-read ?PetOnly $pet Если {@see $petId} будет 0 или null, то вместо DTO тоже будет null
// * @property-read ?PetTypeOnly $petType
// * @property-read ?BreedOnly $petBreed
// * @property-read InvoiceOnly[] $invoices Игнорирую какую-то странную дату со временем под ключом 'd' - не смотрел как формируется. При других запросах такого элемента нет
// * @property-read ?UserOnly $user
// * @property-read ?ComboManualItemOnly $type
// * @property-read ?Clinic $clinic
// * @property-read AdmissionOnly[] $admissionsOfPet
// * @property-read AdmissionOnly[] $admissionsOfOwner
// */
abstract class AbstractAdmission extends AbstractActiveRecord implements AdmissionOnlyDtoInterface
{
    public static function getRouteKey(): string
    {
        return 'admission';
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, AdmissionOnlyDto $modelDTO)
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
    public function getAdmissionDateAsDateTime(): DateTime
    {
        return $this->modelDTO->getAdmissionDateAsDateTime();
    }

    /** @inheritDoc */
    public function getDescription(): string
    {
        return $this->modelDTO->getDescription();
    }

    /** @inheritDoc */
    public function getClientId(): ?int
    {
        return $this->modelDTO->getClientId();
    }

    /** @inheritDoc */
    public function getPetId(): ?int
    {
        return $this->modelDTO->getPetId();
    }

    /** @inheritDoc */
    public function getUserId(): ?int
    {
        return $this->modelDTO->getUserId();
    }

    /** @inheritDoc */
    public function getTypeId(): ?int
    {
        return $this->modelDTO->getTypeId();
    }

    /** @inheritDoc */
    public function getAdmissionLengthAsDateInterval(): ?DateInterval
    {
        return $this->modelDTO->getAdmissionLengthAsDateInterval();
    }

    public function getStatusAsEnum(): ?StatusEnum
    {
        return $this->modelDTO->getStatusAsEnum();
    }

    /** @inheritDoc */
    public function getClinicId(): ?int
    {
        return $this->modelDTO->getClinicId();
    }

    /** @inheritDoc */
    public function getIsDirectDirection(): bool
    {
        return $this->modelDTO->getIsDirectDirection();
    }

    /** @inheritDoc */
    public function getCreatorId(): ?int
    {
        return $this->modelDTO->getCreatorId();
    }

    /** @inheritDoc */
    public function getCreateDateAsDateTime(): DateTime
    {
        return $this->modelDTO->getCreateDateAsDateTime();
    }

    /** @inheritDoc */
    public function getEscortId(): ?int
    {
        return $this->modelDTO->getEscortId();
    }

    /** @inheritDoc */
    public function getReceptionWriteChannel(): string
    {
        return $this->modelDTO->getReceptionWriteChannel();
    }

    /** @inheritDoc */
    public function getIsAutoCreate(): bool
    {
        return $this->modelDTO->getIsAutoCreate();
    }

    /** @inheritDoc */
    public function getInvoicesSum(): ?float
    {
        return $this->modelDTO->getInvoicesSum();
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setId(int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setId($value));
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setAdmissionDateAsString(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setAdmissionDateAsString($value));
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setAdmissionDateAsDateTime(DateTime $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setAdmissionDateAsDateTime($value));
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setDescription(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setDescription($value));
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setClientId(int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setClientId($value));
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setPatientId(int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setPatientId($value));
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setUserId(int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setUserId($value));
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setTypeId(int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setTypeId($value));
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setAdmissionLengthAsString(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setAdmissionLengthAsString($value));
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setAdmissionLengthAsDateInterval(DateInterval $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setAdmissionLengthAsDateInterval($value));
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setStatusAsString(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setStatusAsString($value));
    }

    public function setStatusAsEnum(StatusEnum $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setStatusAsEnum($value));
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setClinicId(int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setClinicId($value));
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setIsDirectDirection(bool $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setIsDirectDirection($value));
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCreatorId(int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setCreatorId($value));
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCreateDateAsString(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setCreateDateAsString($value));
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setCreateDateAsDateTime(DateTime $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setCreateDateAsDateTime($value));
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setEscortId(int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setEscortId($value));
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setReceptionWriteChannel(string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setReceptionWriteChannel($value));
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setIsAutoCreate(bool $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setIsAutoCreate($value));
    }

    /** @throws VetmanagerApiGatewayInnerException */
    public function setInvoicesSum(?float $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setInvoicesSum($value));
    }

    abstract public function getUser(): ?AbstractUser;

    abstract public function getAdmissionType(): ?AbstractComboManualItem;

    abstract public function getClient(): ?AbstractClient;

    abstract public function getPet(): ?AbstractPet;

    abstract public function getPetBreed(): ?AbstractBreed;

    abstract public function getPetType(): ?AbstractPetType;

    /** @return InvoiceOnly[] */
    abstract public function getInvoices(): array;

    /** @throws VetmanagerApiGatewayException */
    public function getClinic(): ?Clinic
    {
        return $this->getClinicId() ? (new Facade\Clinic($this->activeRecordFactory))->getById($this->getClinicId()) : null;
    }

    /** @return AdmissionPlusClientAndPetAndInvoices[]
     * @throws VetmanagerApiGatewayException
     */
    public function getAdmissionsOfPet(): array
    {
        return $this->getPetId() ? (new Facade\Admission($this->activeRecordFactory))->getByPetId($this->getPetId()) : [];
    }

    /** @return AdmissionPlusClientAndPetAndInvoices[]
     * @throws VetmanagerApiGatewayException
     */
    public function getAdmissionsOfOwner(): array
    {
        return $this->getClientId() ? (new Facade\Admission($this->activeRecordFactory))->getByClientId($this->getClientId()) : [];
    }
}
