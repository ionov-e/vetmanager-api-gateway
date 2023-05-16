<?php

namespace VetmanagerApiGateway\ActiveRecord;

use Otis22\VetmanagerRestApi\Query\Builder;
use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Interface\RequestGetAllInterface;
use VetmanagerApiGateway\ActiveRecord\Interface\RequestGetByQueryInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\RequestGetAllTrait;
use VetmanagerApiGateway\ActiveRecord\Trait\RequestGetByQuery;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\DTO\BreedDto;
use VetmanagerApiGateway\DTO\ClientDto;
use VetmanagerApiGateway\DTO\InvoiceDto;
use VetmanagerApiGateway\DTO\PetDto;
use VetmanagerApiGateway\DTO\PetTypeDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

final class AdmissionFromGetAll extends AbstractActiveRecord implements RequestGetAllInterface, RequestGetByQueryInterface
{

    use RequestGetAllTrait;
    use RequestGetByQuery;

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

        $this->pet = !empty($originalData['pet']) ? new PetDto($originalData['pet']) : null;
        $this->petType = !empty($originalData['pet']['pet_type_data']) ? new PetTypeDto($originalData['pet']['pet_type_data']) : null;
        /** @psalm-suppress DocblockTypeContradiction */
        $this->petBreed = !empty($originalData['pet']['breed_data']) ? new BreedDto($originalData['pet']['breed_data']) : null;
        $this->client = new ClientDto($originalData['client']);
        $this->waitTime = StringContainer::fromStringOrNull($originalData['wait_time'] ?? '')->string;
        $this->invoices = Invoice::fromMultipleDtosArrays($this->apiGateway, $originalData['invoices'] ?? []); #TODO Was DTO
    }

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


    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'user' => $this->userId ? User::getById($this->apiGateway, $this->userId) : null,
            'clinic' => $this->clinicId ? Clinic::getById($this->apiGateway, $this->clinicId) : null,
            'type' => $this->typeId ? ComboManualItem::getByAdmissionTypeId($this->apiGateway, $this->typeId) : null,
            'admissionsOfPet' => $this->petId ? AdmissionFromGetAll::getByPetId($this->apiGateway, $this->petId) : [],
            'admissionsOfOwner' => $this->clientId ? AdmissionFromGetAll::getByClientId($this->apiGateway, $this->clientId) : [],
            default => $this->$name,
        };
    }
}
