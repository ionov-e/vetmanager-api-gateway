<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use DateInterval;
use DateTime;
use VetmanagerApiGateway\DO\BoolContainer;
use VetmanagerApiGateway\DO\DateIntervalContainer;
use VetmanagerApiGateway\DO\DateTimeContainer;
use VetmanagerApiGateway\DO\Enum\Admission\Status;
use VetmanagerApiGateway\DO\FloatContainer;
use VetmanagerApiGateway\DO\IntContainer;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\DTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/**
 * @property-read DAO\Breed self
 * @property-read ?DAO\User user
 * @property-read ?DAO\Clinic clinic
 * @property-read ?DAO\ComboManualItem type
 * @property-read DAO\AdmissionFromGetAll[] admissionsOfPet
 * @property-read DAO\AdmissionFromGetAll[] admissionsOfOwner
 */
class AdmissionDto implements DtoInterface
{
    /** @var positive-int */
    public int $id;
    /** Пример "2020-12-31 17:51:18". Может быть: "0000-00-00 00:00:00" - переводится в null */
    public ?DateTime $date;
    /** Примеры: "На основании медкарты", "Запись из модуля, к свободному доктору, по услуге Ампутация пальцев" */
    public string $description;
    /** @var ?positive-int */
    public ?int $clientId;
    /** @var ?positive-int */
    public ?int $petId;
    /** @var ?positive-int */
    public ?int $userId;
    /** @var ?positive-int */
    public ?int $typeId;
    /** Примеры: "00:15:00", "00:00:00" (последнее перевожу в null) */
    public ?DateInterval $admissionLength;
    public ?Status $status;
    /** @var ?positive-int В БД встречается "0" - переводим в null */
    public ?int $clinicId;
    /** Насколько я понял, означает: 'Прием без планирования' */
    public bool $isDirectDirection;
    /** @var ?positive-int */
    public ?int $creatorId;
    /** Приходит: "2015-07-08 06:43:44", но бывает и "0000-00-00 00:00:00". Последнее переводится в null */
    public ?DateTime $createDate;
    /** Тут судя по коду, можно привязать еще одного доктора, т.е. ID от {@see DAO\User}. Какой-то врач-помощник что ли.
     * Кроме "0" другие значения искал - не нашел. Думаю передумали реализовывать */
    public ?int $escorterId;
    /** Искал по всем БД: находил только "vetmanager" и "" или null (редко. Пустые перевожу в null) */
    public string $receptionWriteChannel;
    public bool $isAutoCreate;
    /** Default: 0.0000000000 */
    public float $invoicesSum;
    /** Если {@see $petId} будет 0 или null, то вместо DTO тоже будет null */
    public ?PetDto $pet;
    public ?PetTypeDto $petType;
    public ?BreedDto $petBreed;
    public ClientDto $client;
    public string $waitTime;
    /** @var DTO\InvoiceDto[] Игнорирую какую-то странную дату со временем под ключом 'd' - не смотрел как формируется.
     * При других запросах такого элемента нет */
    public array $invoices;

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
     *           }>,
     *          "doctor_data"?: array,
     *          "admission_type_data"?: array
     *     } $originalData
     * @throws VetmanagerApiGatewayException
     */
    public function __construct(array $originalData)
    {


        $this->id = IntContainer::fromStringOrNull($originalData['id'])->positiveInt;
        $this->date = DateTimeContainer::fromFullDateTimeString($originalData['admission_date'])->dateTimeOrNull;
        $this->description = StringContainer::fromStringOrNull($originalData['description'])->string;
        $this->clientId = IntContainer::fromStringOrNull($originalData['client_id'])->positiveIntOrNull;
        $this->petId = IntContainer::fromStringOrNull($originalData['patient_id'])->positiveIntOrNull;
        $this->userId = IntContainer::fromStringOrNull($originalData['user_id'])->positiveIntOrNull;
        $this->typeId = IntContainer::fromStringOrNull($originalData['type_id'])->positiveIntOrNull;
        $this->admissionLength = DateIntervalContainer::fromStringHMS($originalData['admission_length'])->dateIntervalOrNull;
        $this->status = $originalData['status'] ? Status::from($originalData['status']) : null;
        $this->clinicId = IntContainer::fromStringOrNull($originalData['clinic_id'])->positiveIntOrNull;
        $this->isDirectDirection = BoolContainer::fromStringOrNull($originalData['direct_direction'])->bool;
        $this->creatorId = IntContainer::fromStringOrNull($originalData['creator_id'])->positiveIntOrNull;
        $this->createDate = DateTimeContainer::fromFullDateTimeString($originalData['create_date'])->dateTimeOrNull;
        $this->escorterId = IntContainer::fromStringOrNull($originalData['escorter_id'])->positiveIntOrNull;
        $this->receptionWriteChannel = StringContainer::fromStringOrNull($originalData['reception_write_channel'])->string;
        $this->isAutoCreate = BoolContainer::fromStringOrNull($originalData['is_auto_create'])->bool;
        $this->invoicesSum = FloatContainer::fromStringOrNull($originalData['invoices_sum'])->float;

        $this->pet = !empty($originalData['pet'])
            ? DTO\PetDto::fromSingleObjectContents($this->apiGateway, $originalData['pet'])
            : null;
        $this->petType = !empty($originalData['pet']['pet_type_data'])
            ? DTO\PetTypeDto::fromSingleObjectContents($this->apiGateway, $originalData['pet']['pet_type_data'])
            : null;
        /** @psalm-suppress DocblockTypeContradiction */
        $this->petBreed = !empty($originalData['pet']['breed_data'])
            ? DTO\BreedDto::fromSingleObjectContents($this->apiGateway, $originalData['pet']['breed_data'])
            : null;
        $this->client = ClientDto::fromSingleObjectContents($this->apiGateway, $originalData['client']);
        $this->waitTime = StringContainer::fromStringOrNull($originalData['wait_time'] ?? '')->string;
        $this->invoices = InvoiceDto::fromMultipleObjectsContents($this->apiGateway, $originalData['invoices'] ?? []);
    }

    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'self' => DAO\AdmissionFromGetById::getById($this->apiGateway, $this->id),
            'user' => $this->userId ? DAO\User::getById($this->apiGateway, $this->userId) : null,
            'clinic' => $this->clinicId ? DAO\Clinic::getById($this->apiGateway, $this->clinicId) : null,
            'type' => $this->typeId ? DAO\ComboManualItem::getByAdmissionTypeId($this->apiGateway, $this->typeId) : null,
            'admissionsOfPet' => $this->petId ? DAO\AdmissionFromGetAll::getByPetId($this->apiGateway, $this->petId) : [],
            'admissionsOfOwner' => $this->clientId ? DAO\AdmissionFromGetAll::getByClientId($this->apiGateway, $this->clientId) : [],
            default => $this->$name,
        };
    }
}
