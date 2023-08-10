<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Pet;

use DateTime;
use Otis22\VetmanagerRestApi\Query\Builder;
use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecord\Admission\AdmissionPlusClientAndPetAndInvoices;
use VetmanagerApiGateway\ActiveRecord\Breed\AbstractBreed;
use VetmanagerApiGateway\ActiveRecord\Client\AbstractClient;
use VetmanagerApiGateway\ActiveRecord\ComboManualItem\AbstractComboManualItem;
use VetmanagerApiGateway\ActiveRecord\CreatableInterface;
use VetmanagerApiGateway\ActiveRecord\DeletableInterface;
use VetmanagerApiGateway\ActiveRecord\MedicalCard\MedicalCardPlusPet;
use VetmanagerApiGateway\ActiveRecord\MedicalCardByClient\MedicalCardByClient;
use VetmanagerApiGateway\ActiveRecord\PetType\AbstractPetType;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\Pet\PetOnlyDto;
use VetmanagerApiGateway\DTO\Pet\PetOnlyDtoInterface;
use VetmanagerApiGateway\DTO\Pet\SexEnum;
use VetmanagerApiGateway\DTO\Pet\StatusEnum;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade;

///**
// * @property-read PetOnlyDto $originalDto
// * @property positive-int $id
// * @property positive-int $ownerId Ни в одной БД не нашел "null" или "0"
// * @property ?positive-int $typeId
// * @property string $alias
// * @property SexEnum $sex
// * @property DateTime $dateRegister
// * @property ?DateTime $birthday Дата без времени
// * @property string $note
// * @property ?positive-int $breedId
// * @property ?positive-int $oldId
// * @property ?positive-int $colorId
// * @property string $deathNote
// * @property string $deathDate
// * @property string $chipNumber Default: ''. Самые разные строки прилетают
// * @property string $labNumber Default: ''. Самые разные строки прилетают
// * @property StatusEnum $status
// * @property string $picture Datatype: longblob
// * @property ?float $weight
// * @property DateTime $editDate
// * @property-read array{
// * id: numeric-string,
// * owner_id: ?numeric-string,
// * type_id: ?numeric-string,
// * alias: string,
// * sex: ?string,
// * date_register: string,
// * birthday: ?string,
// * note: string,
// * breed_id: ?numeric-string,
// * old_id: ?numeric-string,
// * color_id: ?numeric-string,
// * deathnote: ?string,
// * deathdate: ?string,
// * chip_number: string,
// * lab_number: string,
// * status: string,
// * picture: ?string,
// * weight: ?string,
// * edit_date: string,
// * owner?: array{
// *      id: string,
// *      address: string,
// *      home_phone: string,
// *      work_phone: string,
// *      note: string,
// *      type_id: ?string,
// *      how_find: ?string,
// *      balance: string,
// *      email: string,
// *      city: string,
// *      city_id: ?string,
// *      date_register: string,
// *      cell_phone: string,
// *      zip: string,
// *      registration_index: ?string,
// *      vip: string,
// *      last_name: string,
// *      first_name: string,
// *      middle_name: string,
// *      status: string,
// *      discount: string,
// *      passport_series: string,
// *      lab_number: string,
// *      street_id: string,
// *      apartment: string,
// *      unsubscribe: string,
// *      in_blacklist: string,
// *      last_visit_date: string,
// *      number_of_journal: string,
// *      phone_prefix: ?string
// *      },
// * type?: array{
// *      id: string,
// *      title: string,
// *      picture: string,
// *      type: ?string
// *      },
// * breed?: array{
// *      id: string,
// *      title: string,
// *      pet_type_id: string
// *      },
// * color?: array{
// *      id: string,
// *      combo_manual_id: string,
// *      title: string,
// *      value: string,
// *      dop_param1: string,
// *      dop_param2: string,
// *      dop_param3: string,
// *      is_active: string
// *      }
// * } $originalDataArray
// * @property-read ?ClientOnly $client
// * @property-read ?PetTypeOnly $type
// * @property-read ?BreedOnly $breed
// * @property-read ?ComboManualItemOnly $color
// * @property-read AdmissionOnly[] admissions
// * @property-read AdmissionOnly[] admissionsOfOwner
// * @property-read AbstractMedicalCard[] medicalCards
// * @property-read MedicalCardAsVaccination[] vaccines
// */
abstract class AbstractPet extends AbstractActiveRecord implements PetOnlyDtoInterface, CreatableInterface, DeletableInterface
{
    public static function getRouteKey(): string
    {
        return 'pet';
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, PetOnlyDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    /** @throws VetmanagerApiGatewayException */
    public function create(): self
    {
        return (new Facade\Pet($this->activeRecordFactory))->createNewUsingArray($this->getAsArray());
    }

    /** @throws VetmanagerApiGatewayException */
    public function update(): self
    {
        return (new Facade\Pet($this->activeRecordFactory))->updateUsingIdAndArray($this->getId(), $this->getAsArrayWithSetPropertiesOnly());
    }

    /** @throws VetmanagerApiGatewayException */
    public function delete(): void
    {
        (new Facade\Pet($this->activeRecordFactory))->delete($this->getId());
    }

    /** @inheritDoc */
    public function getId(): int
    {
        return $this->modelDTO->getId();
    }

    /** @inheritDoc */
    public function getOwnerId(): int
    {
        return $this->modelDTO->getOwnerId();
    }

    /** @inheritDoc */
    public function getPetTypeId(): ?int
    {
        return $this->modelDTO->getPetTypeId();
    }

    public function getAlias(): string
    {
        return $this->modelDTO->getAlias();
    }

    public function getSexAsString(): ?string
    {
        return $this->modelDTO->getSexAsString();
    }

    public function getSexAsEnum(): SexEnum
    {
        return $this->modelDTO->getSexAsEnum();
    }

    public function getDateRegisterAsString(): ?string
    {
        return $this->modelDTO->getDateRegisterAsString();
    }

    /** @inheritDoc */
    public function getDateRegisterAsDateTime(): ?DateTime
    {
        return $this->modelDTO->getDateRegisterAsDateTime();
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

    public function getNote(): string
    {
        return $this->modelDTO->getNote();
    }

    /** @inheritDoc */
    public function getBreedId(): ?int
    {
        return $this->modelDTO->getBreedId();
    }

    /** @inheritDoc */
    public function getOldId(): ?int
    {
        return $this->modelDTO->getOldId();
    }

    /** @inheritDoc */
    public function getColorId(): ?int
    {
        return $this->modelDTO->getColorId();
    }

    public function getDeathNote(): string
    {
        return $this->modelDTO->getDeathNote();
    }

    public function getDeathDateAsString(): ?string
    {
        return $this->modelDTO->getDeathDateAsString();
    }

    /** @inheritDoc */
    public function getChipNumber(): string
    {
        return $this->modelDTO->getChipNumber();
    }

    /** @inheritDoc */
    public function getLabNumber(): string
    {
        return $this->modelDTO->getLabNumber();
    }

    public function getStatusAsString(): ?string
    {
        return $this->modelDTO->getStatusAsString();
    }

    public function getStatusAsEnum(): \VetmanagerApiGateway\DTO\Pet\StatusEnum
    {
        return $this->modelDTO->getStatusAsEnum();
    }

    /** @inheritDoc */
    public function getPicture(): string
    {
        return $this->modelDTO->getPicture();
    }

    /** @inheritDoc */
    public function getWeight(): ?float
    {
        return $this->modelDTO->getWeight();
    }

    public function getEditDateAsString(): string
    {
        return $this->modelDTO->getEditDateAsString();
    }

    /** @inheritDoc */
    public function getEditDateAsDateTime(): DateTime
    {
        return $this->modelDTO->getEditDateAsDateTime();
    }

    /** @inheritDoc */
    public function setOwnerId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setOwnerId($value));
    }

    /** @inheritDoc */
    public function setTypeId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setTypeId($value));
    }

    /** @inheritDoc */
    public function setAlias(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setAlias($value));
    }

    /** @inheritDoc */
    public function setSex(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setSex($value));
    }

    /** @inheritDoc */
    public function setDateRegisterFromString(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setDateRegisterFromString($value));
    }

    /** @inheritDoc */
    public function setDateRegisterFromDateTime(DateTime $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setDateRegisterFromDateTime($value));
    }

    /** @inheritDoc */
    public function setBirthdayFromString(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setBirthdayFromString($value));
    }

    /** @inheritDoc */
    public function setBirthdayFromDateTime(DateTime $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setBirthdayFromDateTime($value));
    }

    /** @inheritDoc */
    public function setNote(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setNote($value));
    }

    /** @inheritDoc */
    public function setBreedId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setBreedId($value));
    }

    /** @inheritDoc */
    public function setOldId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setOldId($value));
    }

    /** @inheritDoc */
    public function setColorId(?int $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setColorId($value));
    }

    /** @inheritDoc */
    public function setDeathNote(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setDeathNote($value));
    }

    /** @inheritDoc */
    public function setDeathDateFromString(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setDeathDateFromString($value));
    }

    /** @inheritDoc */
    public function setChipNumber(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setChipNumber($value));
    }

    /** @inheritDoc */
    public function setLabNumber(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setLabNumber($value));
    }

    /** @inheritDoc */
    public function setStatusFromString(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setStatusFromString($value));
    }

    /** @inheritDoc */
    public function setStatusFromEnum(StatusEnum $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setStatusFromEnum($value));
    }

    /** @inheritDoc */
    public function setPicture(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setPicture($value));
    }

    /** @inheritDoc */
    public function setWeight(?float $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setWeight($value));
    }

    /** @inheritDoc */
    public function setEditDateFromString(?string $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setEditDateFromString($value));
    }

    /** @inheritDoc */
    public function setEditDateFromDateTime(DateTime $value): static
    {
        return self::setNewModelDtoFluently($this, $this->modelDTO->setEditDateFromDateTime($value));
    }

    abstract public function getOwner(): AbstractClient;

    abstract public function getPetType(): ?AbstractPetType;

    abstract public function getBreed(): ?AbstractBreed;

    abstract public function getColor(): ?AbstractComboManualItem;

    /** @return AdmissionPlusClientAndPetAndInvoices[]
     * @throws VetmanagerApiGatewayException
     */
    public function getAdmissions(): array
    {
        return (new Facade\Admission($this->activeRecordFactory))->getByPetId($this->getId());
    }

    /** @return AdmissionPlusClientAndPetAndInvoices[]
     * @throws VetmanagerApiGatewayException
     */
    public function getAdmissionsOfOwner(): array
    {
        return (new Facade\Admission($this->activeRecordFactory))->getByClientId($this->getOwnerId());
    }

    /** @return MedicalCardPlusPet[]
     * @throws VetmanagerApiGatewayException
     */
    public function getMedicalCards(): array
    {
        return (new Facade\MedicalCard($this->activeRecordFactory))->getByPagedQuery(
            (new Builder())->where('patient_id', (string)$this->getId())->paginateAll()
        );
    }

    /** @return MedicalCardByClient[]
     * @throws VetmanagerApiGatewayException
     */
    public function getMedicalCardsOfOwner(): array
    {
        return (new Facade\MedicalCardByClient($this->activeRecordFactory))->getByClientId($this->getOwnerId());
    }

    /** @return AdmissionPlusClientAndPetAndInvoices[]
     * @throws VetmanagerApiGatewayException
     */
    public function getVaccines(): array
    {
        return (new Facade\MedicalCardAsVaccination($this->activeRecordFactory))->getByPetId($this->getId());
    }
}
