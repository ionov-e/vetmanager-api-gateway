<?php

namespace VetmanagerApiGateway\ActiveRecord;

use DateInterval;
use DateTime;
use Otis22\VetmanagerRestApi\Query\Builder;
use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Enum\Source;
use VetmanagerApiGateway\ActiveRecord\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\DTO\Enum\Admission\Status;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/**
 * @property-read positive-int id
 * @property-read ?DateTime date Пример "2020-12-31 17:51:18". Может быть: "0000-00-00 00:00:00" - переводится в null
 * @property-read string description Примеры: "На основании медкарты", "Запись из модуля, к свободному доктору, по услуге Ампутация пальцев"
 * @property-read ?positive-int clientId
 * @property-read ?positive-int petId
 * @property-read ?positive-int userId
 * @property-read ?positive-int typeId
 * @property-read ?DateInterval admissionLength Примеры: "00:15:00", "00:00:00" (последнее перевожу в null)
 * @property-read ?Status status;
 * @property-read ?positive-int clinicId В БД встречается "0" - переводим в null
 * @property-read bool isDirectDirection Насколько я понял, означает: 'Прием без планирования'
 * @property-read ?positive-int creatorId
 * @property-read ?DateTime createDate
 * @property-read ?int escorterId Тут судя по коду, можно привязать еще одного доктора, т.е. ID от {@see User}. Какой-то врач-помощник что ли. Кроме "0" другие значения искал - не нашел. Думаю передумали реализовывать
 * @property-read string receptionWriteChannel Искал по всем БД: находил только "vetmanager" и "" или null (редко. Пустые перевожу в null)
 * @property-read bool isAutoCreate
 * @property-read float invoicesSum Default: 0.0000000000
 * @property array{
 *          "id": numeric-string,
 *          "admission_date": string,
 *          "description": string,
 *          "client_id": numeric-string,
 *          "patient_id": numeric-string,
 *          "user_id": numeric-string,
 *          "type_id": numeric-string,
 *          "admission_length": string,
 *          "status": ?string,
 *          "clinic_id": numeric-string,
 *          "direct_direction": string,
 *          "creator_id": numeric-string,
 *          "create_date": string,
 *          "escorter_id": ?numeric-string,
 *          "reception_write_channel": ?string,
 *          "is_auto_create": string,
 *          "invoices_sum": string,
 *          "client": array{
 *                      "id": string,
 *                      "address": string,
 *                      "home_phone": string,
 *                      "work_phone": string,
 *                      "note": string,
 *                      "type_id": ?string,
 *                      "how_find": ?string,
 *                      "balance": string,
 *                      "email": string,
 *                      "city": string,
 *                      "city_id": ?string,
 *                      "date_register": string,
 *                      "cell_phone": string,
 *                      "zip": string,
 *                      "registration_index": ?string,
 *                      "vip": string,
 *                      "last_name": string,
 *                      "first_name": string,
 *                      "middle_name": string,
 *                      "status": string,
 *                      "discount": string,
 *                      "passport_series": string,
 *                      "lab_number": string,
 *                      "street_id": string,
 *                      "apartment": string,
 *                      "unsubscribe": string,
 *                      "in_blacklist": string,
 *                      "last_visit_date": string,
 *                      "number_of_journal": string,
 *                      "phone_prefix": ?string
 *          },
 *          "pet"?: array{
 *                      "id": string,
 *                      "owner_id": ?string,
 *                      "type_id": ?string,
 *                      "alias": string,
 *                      "sex": ?string,
 *                      "date_register": string,
 *                      "birthday": ?string,
 *                      "note": string,
 *                      "breed_id": ?string,
 *                      "old_id": ?string,
 *                      "color_id": ?string,
 *                      "deathnote": ?string,
 *                      "deathdate": ?string,
 *                      "chip_number": string,
 *                      "lab_number": string,
 *                      "status": string,
 *                      "picture": ?string,
 *                      "weight": ?string,
 *                      "edit_date": string,
 *                      "pet_type_data": array{}|array{
 *                              "id": string,
 *                              "title": string,
 *                              "picture": string,
 *                              "type": ?string,
 *                      },
 *                      "breed_data": array{
 *                              "id": string,
 *                              "title": string,
 *                              "pet_type_id": string,
 *                      }
 *          },
 *          "doctor_data"?: array{
 *                      "id": string,
 *                      "last_name": string,
 *                      "first_name": string,
 *                      "middle_name": string,
 *                      "login": string,
 *                      "passwd": string,
 *                      "position_id": ?string,
 *                      "email": string,
 *                      "phone": string,
 *                      "cell_phone": string,
 *                      "address": string,
 *                      "role_id": ?string,
 *                      "is_active": string,
 *                      "calc_percents": string,
 *                      "nickname": ?string,
 *                      "last_change_pwd_date": string,
 *                      "is_limited": string,
 *                      "carrotquest_id": ?string,
 *                      "sip_number": string,
 *                      "user_inn": string
 *          },
 *          "admission_type_data"?: array{
 *                      "id": string,
 *                      "combo_manual_id": string,
 *                      "title": string,
 *                      "value": string,
 *                      "dop_param1": string,
 *                      "dop_param2": string,
 *                      "dop_param3": string,
 *                      "is_active": string,
 *          },
 *          "wait_time"?: string,
 *          "invoices"?: array<int, array{
 *                              "id": string,
 *                              "doctor_id": ?string,
 *                              "client_id": string,
 *                              "pet_id": string,
 *                              "description": string,
 *                              "percent": ?string,
 *                              "amount": ?string,
 *                              "status": string,
 *                              "invoice_date": string,
 *                              "old_id": ?string,
 *                              "night": string,
 *                              "increase": ?string,
 *                              "discount": ?string,
 *                              "call": string,
 *                              "paid_amount": string,
 *                              "create_date": string,
 *                              "payment_status": string,
 *                              "clinic_id": string,
 *                              "creator_id": ?string,
 *                              "fiscal_section_id": string,
 *                              "d": string
 *           }>
 *     } originalDataArray Массив, полученный по ID отличается от Get All лишь наличием двух дополнительных DTO: 1) {@see self::type} из элемента admission_type_data; 2) {@see self::user} из элемента doctor_data
 * @property-read string waitTime
 * @property-read Client client
 * @property-read ?Pet $pet Если {@see $petId} будет 0 или null, то вместо DTO тоже будет null
 * @property-read ?PetType petType
 * @property-read ?Breed petBreed
 * @property-read Invoice[] invoices Игнорирую какую-то странную дату со временем под ключом 'd' - не смотрел как формируется. При других запросах такого элемента нет
 * @property-read ?User user
 * @property-read ?ComboManualItem type
 * @property-read ?Clinic clinic
 * @property-read Admission[] admissionsOfPet
 * @property-read Admission[] admissionsOfOwner
 */
final class Admission extends AbstractActiveRecord implements AllGetRequestsInterface
{
    use AllGetRequestsTrait;

    /** Не возвращаются со статусом "удален"
     * @return self[]
     * @throws VetmanagerApiGatewayException
     */
    public static function getByClientId(ApiGateway $apiGateway, int $clientId, int $maxLimit = 100): array
    {
        return self::getByQueryBuilder(
            $apiGateway,
            (new Builder())
                ->where('client_id', (string)$clientId)
                ->where('status', '!=', 'deleted'),
            $maxLimit
        );
    }

    /** Не возвращаются со статусом "удален"
     * @return self[]
     * @throws VetmanagerApiGatewayException
     */
    public static function getByPetId(ApiGateway $apiGateway, int $petId, int $maxLimit = 100): array
    {
        return self::getByQueryBuilder(
            $apiGateway,
            (new Builder())
                ->where('patient_id', (string)$petId)
                ->where('status', '!=', 'deleted'),
            $maxLimit
        );
    }

    /** @return ApiModel::Admission */
    public static function getApiModel(): ApiModel
    {
        return ApiModel::Admission;
    }

    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        switch ($name) {
            case 'user':
            case 'type':
                $this->fillCurrentObjectWithGetByIdDataIfSourceIsDifferent();
                break;
            case 'client':
            case 'pet':
            case 'petType':
            case 'petBreed':
            case 'waitTime':
            case 'invoices':
                $this->fillCurrentObjectWithGetByIdDataIfSourceIsFromBasicDto();
        }

        return match ($name) {
            'user' => !empty($this->originalDataArray['doctor_data'])
                ? User::fromSingleDtoArrayUsingBasicDto($this->apiGateway, $this->originalDataArray['doctor_data'])
                : null,
            'type' => !empty($this->originalDataArray['admission_type_data'])
                ? ComboManualItem::fromSingleDtoArrayUsingBasicDto($this->apiGateway, $this->originalDataArray['admission_type_data'])
                : null,
            'client' => Client::fromSingleDtoArrayUsingBasicDto($this->apiGateway, $this->originalDataArray['client']),
            'pet' => !empty($this->originalDataArray['pet'])
                ? Pet::fromSingleDtoArrayUsingBasicDto($this->apiGateway, $this->originalDataArray['pet'])
                : null,
            'petType' => !empty($this->originalDataArray['pet']['pet_type_data'])
                ? PetType::fromSingleDtoArrayUsingBasicDto($this->apiGateway, $this->originalDataArray['pet']['pet_type_data'])
                : null,
            /** @psalm-suppress DocblockTypeContradiction */
            'petBreed' => !empty($this->originalDataArray['pet']['breed_data'])
                ? Breed::fromSingleDtoArrayUsingBasicDto($this->apiGateway, $this->originalDataArray['pet']['breed_data'])
                : null,
            'waitTime' => StringContainer::fromStringOrNull($this->originalDataArray['wait_time'] ?? '')->string,
            'invoices' => Invoice::fromMultipleDtosArrays($this->apiGateway, $this->originalDataArray['invoices'] ?? [], Source::OnlyBasicDto),
            'clinic' => $this->clinicId ? Clinic::getById($this->apiGateway, $this->clinicId) : null,
            'admissionsOfPet' => $this->petId ? self::getByPetId($this->apiGateway, $this->petId) : [],
            'admissionsOfOwner' => $this->clientId ? self::getByClientId($this->apiGateway, $this->clientId) : [],
            default => $this->originalDto->$name
        };
    }
}
