<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use DateInterval;
use DateTime;
use VetmanagerApiGateway\ActiveRecord\User;
use VetmanagerApiGateway\DTO\Enum\Admission\Status;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Hydrator\ApiBool;
use VetmanagerApiGateway\Hydrator\ApiDateInterval;
use VetmanagerApiGateway\Hydrator\ApiDateTime;
use VetmanagerApiGateway\Hydrator\ApiFloat;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;
use VetmanagerApiGateway\Hydrator\DtoPropertyList;

class AdmissionDto extends AbstractDTO
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
    /** Тут судя по коду, можно привязать еще одного доктора, т.е. ID от {@see User}. Какой-то врач-помощник что ли.
     * Кроме "0" другие значения искал - не нашел. Думаю передумали реализовывать */
    public ?int $escortId;
    /** Искал по всем БД: находил только "vetmanager" и "" или null (редко. Пустые перевожу в null) */
    public string $receptionWriteChannel;
    public bool $isAutoCreate;
    /** Default: 0.0000000000 */
    public float $invoicesSum;

    /** @param array{
     *          id: numeric-string,
     *          admission_date: string,
     *          description: string,
     *          client_id: numeric-string,
     *          patient_id: numeric-string,
     *          user_id: numeric-string,
     *          type_id: numeric-string,
     *          admission_length: string,
     *          status: ?string,
     *          clinic_id: numeric-string,
     *          direct_direction: string,
     *          creator_id: numeric-string,
     *          create_date: string,
     *          escorter_id: ?numeric-string,
     *          reception_write_channel: ?string,
     *          is_auto_create: string,
     *          invoices_sum: string,
     *          client: array,
     *          pet?: array,
     *          wait_time?: string,
     *          invoices?: array,
     *          doctor_data?: array,
     *          admission_type_data?: array
     *     } $originalDataArray
     * @throws VetmanagerApiGatewayException
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public static function fromApiResponseArray(array $originalDataArray): self
    {
        $instance = new self($originalDataArray);
        $instance->id = ApiInt::fromStringOrNull($originalDataArray['id'])->getPositiveInt();
        $instance->date = ApiDateTime::fromFullDateTimeString($originalDataArray['admission_date'])->getDateTimeOrThrow();
        $instance->description = ApiString::fromStringOrNull($originalDataArray['description'])->getStringEvenIfNullGiven();
        $instance->clientId = ApiInt::fromStringOrNull($originalDataArray['client_id'])->getPositiveIntOrNull();
        $instance->petId = ApiInt::fromStringOrNull($originalDataArray['patient_id'])->getPositiveIntOrNull();
        $instance->userId = ApiInt::fromStringOrNull($originalDataArray['user_id'])->getPositiveIntOrNull();
        $instance->typeId = ApiInt::fromStringOrNull($originalDataArray['type_id'])->getPositiveIntOrNull();
        $instance->admissionLength = ApiDateInterval::fromStringHMS($originalDataArray['admission_length'])->getDateIntervalOrNull();
        $instance->status = $originalDataArray['status'] ? Status::from($originalDataArray['status']) : null;
        $instance->clinicId = ApiInt::fromStringOrNull($originalDataArray['clinic_id'])->getPositiveIntOrNull();
        $instance->isDirectDirection = ApiBool::fromStringOrNull($originalDataArray['direct_direction'])->getBoolOrThrowIfNull();
        $instance->creatorId = ApiInt::fromStringOrNull($originalDataArray['creator_id'])->getPositiveIntOrNull();
        $instance->createDate = ApiDateTime::fromFullDateTimeString($originalDataArray['create_date'])->getDateTimeOrThrow();
        $instance->escortId = ApiInt::fromStringOrNull($originalDataArray['escorter_id'])->getPositiveIntOrNull();
        $instance->receptionWriteChannel = ApiString::fromStringOrNull($originalDataArray['reception_write_channel'])->getStringEvenIfNullGiven();
        $instance->isAutoCreate = ApiBool::fromStringOrNull($originalDataArray['is_auto_create'])->getBoolOrThrowIfNull();
        $instance->invoicesSum = ApiFloat::fromStringOrNull($originalDataArray['invoices_sum'])->getNonZeroFloatOrNull();
        return $instance;
    }

    /** @inheritdoc */
    public function getRequiredKeysForPostArray(): array #TODO No Idea
    {
        return [];
    }

    /** @inheritdoc
     * @throws VetmanagerApiGatewayRequestException
     */
    protected function getSetValuesWithoutId(): array
    {
        return (new DtoPropertyList(
            $this,
            ['date', 'admission_date'],
            ['description', 'description'],
            ['clientId', 'client_id'],
            ['petId', 'patient_id'],
            ['userId', 'user_id'],
            ['typeId', 'type_id'],
            ['admissionLength', 'admission_length'],
            ['status', 'status'],
            ['clinicId', 'clinic_id'],
            ['isDirectDirection', 'direct_direction'],
            ['creatorId', 'creator_id'],
            ['createDate', 'create_date'],
            ['escortId', 'escorter_id'],
            ['receptionWriteChannel', 'reception_write_channel'],
            ['isAutoCreate', 'is_auto_create'],
            ['invoicesSum', 'invoices_sum'],
        ))->toArray();
    }
}
