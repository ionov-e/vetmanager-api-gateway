<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO\DTO;

use DateInterval;
use DateTime;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\DateIntervalContainer;
use VetmanagerApiGateway\DO\DateTimeContainer;
use VetmanagerApiGateway\DO\DTO\DAO\AdmissionFromGetById;
use VetmanagerApiGateway\DO\DTO\DAO\Clinic;
use VetmanagerApiGateway\DO\Enum\Admission\Status;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/**
 * @property-read \VetmanagerApiGateway\DO\DTO\DAO\Breed self
 * @property-read ?\VetmanagerApiGateway\DO\DTO\DAO\User user
 * @property-read ?Clinic clinic
 * @property-read ?\VetmanagerApiGateway\DO\DTO\DAO\ComboManualItem type
 */
class Admission extends AbstractDTO
{
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
    /** Примеры: "00:15:00", "00:00:00" (последнее переводжу в null) */
    public ?DateInterval $admissionLength;
    public Status $status;
    /** @var ?positive-int В БД встречается "0" - переводим в null */
    public ?int $clinicId;
    /** Насколько я понял, означает: 'Прием без планирования' */
    public bool $isDirectDirection;
    /** @var ?positive-int */
    public ?int $creatorId;
    /** Приходит: "2015-07-08 06:43:44", но бывает и "0000-00-00 00:00:00". Последнее переводится в null */
    public ?DateTime $createDate;
    /** Тут судя по коду, можно привязать еще одного доктора, т.е. ID от {@see \VetmanagerApiGateway\DO\DTO\DAO\User}. Какой-то врач-помощник что ли.
     * Кроме "0" другие значения искал - не нашел. Думаю передумали реализовывать */
    public int $escorterId;
    /** Искал по всем БД: находил только "vetmanager" и "" или null (редко. Пустые перевожу в null) */
    public ?string $receptionWriteChannel;
    public bool $isAutoCreate;
    /** Default: 0.0000000000 */
    public float $invoicesSum;

    /** @var array{
     *          "id": string,
     *          "admission_date": string,
     *          "description": string,
     *          "client_id": string,
     *          "patient_id": string,
     *          "user_id": string,
     *          "type_id": string,
     *          "admission_length": string,
     *          "status": ?string,
     *          "clinic_id": string,
     *          "direct_direction": string,
     *          "creator_id": string,
     *          "create_date": string,
     *          "escorter_id": ?string,
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
     *          ?"pet": array{
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
     *          ?"wait_time": string,
     *          ?"invoices": array<int, array{
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
     */
    protected readonly array $originalData;

    /** Если {@see $petId} будет 0 или null, то вместо DTO тоже будет null */
    public ?Pet $pet;
    public ?PetType $petType;
    public ?Pet $petBreed;
    public Client $client;
    /** Все время пустая строка приходит - перевожу в null */
    public ?string $waitTime;
    /** @var Invoice[] Игнорирую какую-то странную дату со временем под ключом 'd' - не смотрел как формируется.
     * При других запросах такого элемента нет */
    public array $invoices;

    /** @throws VetmanagerApiGatewayException */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = (int)$this->originalData['id'];
        $this->date = (DateTimeContainer::fromFullDateTimeString($this->originalData['admission_date']))->dateTimeNullable;
        $this->description = (string)$this->originalData['description'];
        $this->clientId = $this->originalData['client_id'] ? (int)$this->originalData['client_id'] : null;
        $this->petId = $this->originalData['patient_id'] ? (int)$this->originalData['patient_id'] : null;
        $this->userId = $this->originalData['user_id'] ? (int)$this->originalData['user_id'] : null;
        $this->typeId = $this->originalData['type_id'] ? (int)$this->originalData['type_id'] : null;
        $this->admissionLength = (DateIntervalContainer::fromStringHMS($this->originalData['admission_length']))->dateIntervalNullable;
        $this->status = Status::from($this->originalData['status']);
        $this->clinicId = $this->originalData['clinic_id'] ? (int)$this->originalData['clinic_id'] : null;
        $this->isDirectDirection = (bool)$this->originalData['direct_direction'];
        $this->creatorId = $this->originalData['creator_id'] ? (int)$this->originalData['creator_id'] : null;
        $this->createDate = (DateTimeContainer::fromFullDateTimeString($this->originalData['create_date']))->dateTimeNullable;
        $this->escorterId = $this->originalData['escorter_id'] ? (int)$this->originalData['escorter_id'] : null;
        $this->receptionWriteChannel = $this->originalData['reception_write_channel'] ? (string)$this->originalData['reception_write_channel'] : null;
        $this->isAutoCreate = (bool)$this->originalData['is_auto_create'];
        $this->invoicesSum = (float)$this->originalData['invoices_sum'];

        $this->pet = !empty($this->originalData['pet'])
            ? Pet::fromSingleObjectContents($this->apiGateway, $this->originalData['pet'])
            : null;
        $this->petType = !empty($this->originalData['pet']['pet_type_data'])
            ? PetType::fromSingleObjectContents($this->apiGateway, $this->originalData['pet']['pet_type_data'])
            : null;
        $this->petBreed = !empty($this->originalData['pet']['breed_data'])
            ? Breed::fromSingleObjectContents($this->apiGateway, $this->originalData['pet']['breed_data'])
            : null;
        $this->client = Client::fromSingleObjectContents($this->apiGateway, $this->originalData['client']);
        $this->waitTime = (string)$this->originalData['wait_time'] ?: null;
        $this->invoices = Invoice::fromMultipleObjectsContents(
            $this->apiGateway,
            $this->originalData['invoices'] ?? []
        );
    }

    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'self' => AdmissionFromGetById::getById($this->apiGateway, $this->id),
            'user' => $this->userId ? \VetmanagerApiGateway\DO\DTO\DAO\User::getById($this->apiGateway, $this->userId) : null,
            'clinic' => $this->clinicId ? Clinic::getById($this->apiGateway, $this->clinicId) : null,
            'type' => $this->typeId ? \VetmanagerApiGateway\DO\DTO\DAO\ComboManualItem::getByAdmissionTypeId($this->apiGateway, $this->typeId) : null,
            default => $this->$name,
        };
    }
}
