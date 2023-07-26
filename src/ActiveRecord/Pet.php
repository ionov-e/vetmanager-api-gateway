<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use DateTime;
use Otis22\VetmanagerRestApi\Query\Builder;
use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Enum\Completeness;
use VetmanagerApiGateway\ActiveRecord\Interface\AllRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllRequestsTrait;
use VetmanagerApiGateway\DTO\Enum\Pet\Sex;
use VetmanagerApiGateway\DTO\Enum\Pet\Status;
use VetmanagerApiGateway\DTO\PetDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/**
 * @property-read PetDto $originalDto
 * @property positive-int $id
 * @property positive-int $ownerId Ни в одной БД не нашел "null" или "0"
 * @property ?positive-int $typeId
 * @property string $alias
 * @property Sex $sex
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
 * @property Status $status
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
 * @property-read ?Client $client
 * @property-read ?PetType $type
 * @property-read ?Breed $breed
 * @property-read ?ComboManualItem $color
 * @property-read Admission[] admissions
 * @property-read Admission[] admissionsOfOwner
 * @property-read MedicalCard[] medicalCards
 * @property-read MedicalCardAsVaccination[] vaccines
 */
final class Pet extends AbstractActiveRecord implements AllRequestsInterface
{
    use AllRequestsTrait;

    /** @return ApiModel::Pet */
    public static function getApiModel(): ApiModel
    {
        return ApiModel::Pet;
    }

    public static function getCompletenessFromGetAllOrByQuery(): Completeness
    {
        return Completeness::Full;
    }

    /** @throws VetmanagerApiGatewayException
     * @psalm-suppress DocblockTypeContradiction
     */
    public function __get(string $name): mixed
    {
        if ($this->completenessLevel != Completeness::Full) {
            switch ($name) {
                case 'client':
                    return Client::getById($this->activeRecordFactory, $this->ownerId);
                case 'type':
                    return $this->typeId ? PetType::getById($this->activeRecordFactory, $this->typeId) : null;
                case 'breed':
                    return $this->breedId ? Breed::getById($this->activeRecordFactory, $this->breedId) : null;
                case 'color':
                    return $this->colorId ? ComboManualItem::getByPetColorId($this->activeRecordFactory, $this->colorId) : null;
            }
        }

        return match ($name) {
            'client' => !empty($this->originalDataArray['owner'])
                ? Client::fromSingleDtoArrayUsingBasicDto($this->activeRecordFactory, $this->originalDataArray['owner'])
                : null,
            'type' => !empty($this->originalDataArray['type'])
                ? PetType::fromSingleDtoArrayUsingBasicDto($this->activeRecordFactory, $this->originalDataArray['type'])
                : null,
            'breed' => $this->getBreedActiveRecordOrNull(),
            'color' => !empty($this->originalDataArray['color'])
                ? ComboManualItem::fromSingleDtoArrayUsingBasicDto($this->activeRecordFactory, $this->originalDataArray['color'])
                : null,
            'admissions' => Admission::getByPetId($this->activeRecordFactory, $this->id),
            'admissionsOfOwner' => Admission::getByClientId($this->activeRecordFactory, $this->ownerId),
            'medicalCards' => MedicalCard::getByPagedQuery(
                $this->activeRecordFactory,
                (new Builder())->where('patient_id', (string)$this->id)->paginateAll()
            ),
            'vaccines' => MedicalCardAsVaccination::getByPetId($this->activeRecordFactory, $this->id),
            default => $this->originalDto->$name,
        };
    }

    /** @throws VetmanagerApiGatewayException */
    private function getBreedActiveRecordOrNull(): ?Breed
    {
        if (empty($this->originalDataArray['breed'])) {
            return null;
        }

        $typeArray = (!empty($this->originalDataArray['type']))
            ? ["petType" => $this->originalDataArray['type']]
            : [];

        $arrayForFullBreedActiveRecord = array_merge(
            $this->originalDataArray['breed'],
            $typeArray
        );

        return Breed::fromSingleDtoArrayAsFromGetById($this->activeRecordFactory, $arrayForFullBreedActiveRecord);
    }
}
