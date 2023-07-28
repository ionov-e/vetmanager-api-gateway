<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Pet;

use DateTime;
use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecord\Admission\AdmissionOnly;
use VetmanagerApiGateway\ActiveRecord\Breed\Breed;
use VetmanagerApiGateway\ActiveRecord\Client\ClientOnly;
use VetmanagerApiGateway\ActiveRecord\ComboManualItem\ComboManualItemOnly;
use VetmanagerApiGateway\ActiveRecord\MedicalCard\AbstractMedicalCard;
use VetmanagerApiGateway\ActiveRecord\MedicalCardAsVaccination\MedicalCardAsVaccination;
use VetmanagerApiGateway\ActiveRecord\PetType\PetTypeOnly;
use VetmanagerApiGateway\DTO\Pet\PetOnlyDto;
use VetmanagerApiGateway\DTO\Pet\SexEnum;
use VetmanagerApiGateway\DTO\Pet\StatusEnum;

/**
 * @property-read PetOnlyDto $originalDto
 * @property positive-int $id
 * @property positive-int $ownerId Ни в одной БД не нашел "null" или "0"
 * @property ?positive-int $typeId
 * @property string $alias
 * @property SexEnum $sex
 * @property DateTime $dateRegister
 * @property ?DateTime $birthday Дата без времени
 * @property string $note
 * @property ?positive-int $breedId
 * @property ?positive-int $oldId
 * @property ?positive-int $colorId
 * @property string $deathNote
 * @property string $deathDate
 * @property string $chipNumber Default: ''. Самые разные строки прилетают
 * @property string $labNumber Default: ''. Самые разные строки прилетают
 * @property StatusEnum $status
 * @property string $picture Datatype: longblob
 * @property ?float $weight
 * @property DateTime $editDate
 * @property-read array{
 * id: numeric-string,
 * owner_id: ?numeric-string,
 * type_id: ?numeric-string,
 * alias: string,
 * sex: ?string,
 * date_register: string,
 * birthday: ?string,
 * note: string,
 * breed_id: ?numeric-string,
 * old_id: ?numeric-string,
 * color_id: ?numeric-string,
 * deathnote: ?string,
 * deathdate: ?string,
 * chip_number: string,
 * lab_number: string,
 * status: string,
 * picture: ?string,
 * weight: ?string,
 * edit_date: string,
 * owner?: array{
 *      id: string,
 *      address: string,
 *      home_phone: string,
 *      work_phone: string,
 *      note: string,
 *      type_id: ?string,
 *      how_find: ?string,
 *      balance: string,
 *      email: string,
 *      city: string,
 *      city_id: ?string,
 *      date_register: string,
 *      cell_phone: string,
 *      zip: string,
 *      registration_index: ?string,
 *      vip: string,
 *      last_name: string,
 *      first_name: string,
 *      middle_name: string,
 *      status: string,
 *      discount: string,
 *      passport_series: string,
 *      lab_number: string,
 *      street_id: string,
 *      apartment: string,
 *      unsubscribe: string,
 *      in_blacklist: string,
 *      last_visit_date: string,
 *      number_of_journal: string,
 *      phone_prefix: ?string
 *      },
 * type?: array{
 *      id: string,
 *      title: string,
 *      picture: string,
 *      type: ?string
 *      },
 * breed?: array{
 *      id: string,
 *      title: string,
 *      pet_type_id: string
 *      },
 * color?: array{
 *      id: string,
 *      combo_manual_id: string,
 *      title: string,
 *      value: string,
 *      dop_param1: string,
 *      dop_param2: string,
 *      dop_param3: string,
 *      is_active: string
 *      }
 * } $originalDataArray
 * @property-read ?ClientOnly $client
 * @property-read ?PetTypeOnly $type
 * @property-read ?Breed $breed
 * @property-read ?ComboManualItemOnly $color
 * @property-read AdmissionOnly[] admissions
 * @property-read AdmissionOnly[] admissionsOfOwner
 * @property-read AbstractMedicalCard[] medicalCards
 * @property-read MedicalCardAsVaccination[] vaccines
 */
abstract class AbstractPet extends AbstractActiveRecord
{
    public static function getRouteKey(): string
    {
        return 'pet';
    }

//    public static function getCompletenessFromGetAllOrByQuery(): Completeness
//    {
//        return Completeness::Full;
//    }

//    /** @throws VetmanagerApiGatewayException
//     * @psalm-suppress DocblockTypeContradiction
//     */
//    public function __get(string $name): mixed
//    {
//        if ($this->completenessLevel != Completeness::Full) {
//            switch ($name) {
//                case 'client':
//                    return ClientOnly::getById($this->activeRecordFactory, $this->ownerId);
//                case 'type':
//                    return $this->typeId ? PetType::getById($this->activeRecordFactory, $this->typeId) : null;
//                case 'breed':
//                    return $this->breedId ? Breed::getById($this->activeRecordFactory, $this->breedId) : null;
//                case 'color':
//                    return $this->colorId ? ComboManualItemOnly::getByPetColorId($this->activeRecordFactory, $this->colorId) : null;
//            }
//        }
//
//        return match ($name) {
//            'client' => !empty($this->originalDataArray['owner'])
//                ? ClientOnly::fromSingleDtoArrayUsingBasicDto($this->activeRecordFactory, $this->originalDataArray['owner'])
//                : null,
//            'type' => !empty($this->originalDataArray['type'])
//                ? PetType::fromSingleDtoArrayUsingBasicDto($this->activeRecordFactory, $this->originalDataArray['type'])
//                : null,
//            'breed' => $this->getBreedActiveRecordOrNull(),
//            'color' => !empty($this->originalDataArray['color'])
//                ? ComboManualItemOnly::fromSingleDtoArrayUsingBasicDto($this->activeRecordFactory, $this->originalDataArray['color'])
//                : null,
//            'admissions' => AdmissionOnly::getByPetId($this->activeRecordFactory, $this->id),
//            'admissionsOfOwner' => AdmissionOnly::getByClientId($this->activeRecordFactory, $this->ownerId),
//            'medicalCards' => AbstractMedicalCard::getByPagedQuery(
//                $this->activeRecordFactory,
//                (new Builder())->where('patient_id', (string)$this->id)->paginateAll()
//            ),
//            'vaccines' => MedicalCardAsVaccination::getByPetId($this->activeRecordFactory, $this->id),
//            default => $this->originalDto->$name,
//        };
//    }
//
//    /** @throws VetmanagerApiGatewayException */
//    private function getBreedActiveRecordOrNull(): ?Breed
//    {
//        if (empty($this->originalDataArray['breed'])) {
//            return null;
//        }
//
//        $typeArray = (!empty($this->originalDataArray['type']))
//            ? ["petType" => $this->originalDataArray['type']]
//            : [];
//
//        $arrayForFullBreedActiveRecord = array_merge(
//            $this->originalDataArray['breed'],
//            $typeArray
//        );
//
//        return Breed::fromSingleDtoArrayAsFromGetById($this->activeRecordFactory, $arrayForFullBreedActiveRecord);
//    }
}
