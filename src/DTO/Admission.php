<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use DateInterval;
use DateTime;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO\Enum\Admission\Status;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Service\DateIntervalService;
use VetmanagerApiGateway\Service\DateTimeService;

/**
 * @property-read DAO\Breed $self
 * @property-read \VetmanagerApiGateway\DTO\DAO\PetType $type
 */
class Admission extends AbstractDTO
{
    public int $id;
    /** Пример "2020-12-31 17:51:18" */
    public DateTime $date;
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
    /** Тут судя по коду, можно привязать еще одного доктора, т.е. ID от {@see DAO\User}. Какой-то врач-помощник что ли.
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
     *     } $originalData
     */
    protected readonly array $originalData;

    /** @throws VetmanagerApiGatewayException */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = (int)$this->originalData['id'];
        $this->date = (DateTimeService::fromFullDateTimeString($this->originalData['admission_date']))->dateTime;
        $this->description = (string)$this->originalData['description'];
        $this->clientId = $this->originalData['client_id'] ? (int)$this->originalData['client_id'] : null;
        $this->petId = $this->originalData['patient_id'] ? (int)$this->originalData['patient_id'] : null;
        $this->userId = $this->originalData['user_id'] ? (int)$this->originalData['user_id'] : null;
        $this->typeId = $this->originalData['type_id'] ? (int)$this->originalData['type_id'] : null;
        $this->admissionLength = (DateIntervalService::fromStringHMS($this->originalData['admission_length']))->dateInterval;
        $this->status = Status::from($this->originalData['status']);
        $this->clinicId = $this->originalData['clinic_id'] ? (int)$this->originalData['clinic_id'] : null;
        $this->isDirectDirection = (bool)$this->originalData['direct_direction'];
        $this->creatorId = $this->originalData['creator_id'] ? (int)$this->originalData['creator_id'] : null;
        $this->createDate = (DateTimeService::fromFullDateTimeString($this->originalData['create_date']))->dateTime;
        $this->escorterId = $this->originalData['escorter_id'] ? (int)$this->originalData['escorter_id'] : null;
        $this->receptionWriteChannel = $this->originalData['reception_write_channel'] ? (string)$this->originalData['reception_write_channel'] : null;
        $this->isAutoCreate = (bool)$this->originalData['is_auto_create'];
        $this->invoicesSum = (float)$this->originalData['invoices_sum'];
    }
}
