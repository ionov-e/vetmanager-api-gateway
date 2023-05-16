<?php

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Interface\RequestGetByIdInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\RequestGetByIdTrait;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\DTO;
use VetmanagerApiGateway\DTO\BreedDto;
use VetmanagerApiGateway\DTO\ClientDto;
use VetmanagerApiGateway\DTO\ComboManualItemDto;
use VetmanagerApiGateway\DTO\InvoiceDto;
use VetmanagerApiGateway\DTO\PetDto;
use VetmanagerApiGateway\DTO\PetTypeDto;
use VetmanagerApiGateway\DTO\UserDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/** Содержимое отличает от {@see AdmissionFromGetAll} лишь наличием двух дополнительных DTO:
 * 1) {@see self::$type} из элемента admission_type_data
 * 2) {@see self::$user} из элемента doctor_data
 */
final class AdmissionFromGetById extends AbstractActiveRecord implements RequestGetByIdInterface
{

    use RequestGetByIdTrait;

    public readonly ?UserDto $user;
    public readonly ?ComboManualItemDto $type;

    /** Если {@see $petId} будет 0 или null, то вместо DTO тоже будет null */
    public ?PetDto $pet;
    public ?PetTypeDto $petType;
    public ?BreedDto $petBreed;
    public ClientDto $client;
    public string $waitTime;
    /** @var InvoiceDto[] Игнорирую какую-то странную дату со временем под ключом 'd' - не смотрел как формируется.
     * При других запросах такого элемента нет */
    public array $invoices;

    /** @return ApiModel::Admission */
    public static function getApiModel(): ApiModel
    {
        return ApiModel::Admission;
    }

    /** @param array{
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
     *     } $originalData
     * @throws VetmanagerApiGatewayException
     */
    public function __construct(ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->pet = !empty($originalData['pet'])
            ? PetDto::fromSingleObjectContents($this->apiGateway, $originalData['pet'])
            : null;
        $this->petType = !empty($originalData['pet']['pet_type_data'])
            ? PetTypeDto::fromSingleObjectContents($this->apiGateway, $originalData['pet']['pet_type_data'])
            : null;
        /** @psalm-suppress DocblockTypeContradiction */
        $this->petBreed = !empty($originalData['pet']['breed_data'])
            ? BreedDto::fromSingleObjectContents($this->apiGateway, $originalData['pet']['breed_data'])
            : null;
        $this->client = ClientDto::fromSingleObjectContents($this->apiGateway, $originalData['client']);
        $this->waitTime = StringContainer::fromStringOrNull($originalData['wait_time'] ?? '')->string;
        $this->invoices = InvoiceDto::fromMultipleObjectsContents($this->apiGateway, $originalData['invoices'] ?? []);

        $this->user = !empty($originalData['doctor_data'])
            ? DTO\UserDto::fromSingleObjectContents($this->apiGateway, $originalData['doctor_data'])
            : null;
        $this->type = !empty($originalData['admission_type_data'])
            ? DTO\ComboManualItemDto::fromSingleObjectContents($this->apiGateway, $originalData['admission_type_data'])
            : null;
    }


    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'user' => $this->userId ? User::getById($this->apiGateway, $this->userId) : null,
            'clinic' => $this->clinicId ? Clinic::getById($this->apiGateway, $this->clinicId) : null,
            'type' => $this->typeId ? ComboManualItem::getByAdmissionTypeId($this->apiGateway, $this->typeId) : null,
            'admissionsOfPet' => $this->petId ? AdmissionFromGetAll::getByPetId($this->apiGateway, $this->petId) : [],
            'admissionsOfOwner' => $this->clientId ? AdmissionFromGetAll::getByClientId($this->apiGateway, $this->clientId) : [],
            default => $this->originalDto->$name
        };
    }
}
