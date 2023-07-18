<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use DateTime;
use VetmanagerApiGateway\DTO\Enum\MedicalCard\Status;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Hydrator\ApiDateTime;
use VetmanagerApiGateway\Hydrator\ApiFloat;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;
use VetmanagerApiGateway\Hydrator\DtoPropertyList;

final class MedicalCardDto extends AbstractDTO
{
    /** @var positive-int */
    public int $id;
    /** @var positive-int */
    public int $petId;
    public DateTime $dateCreate;
    public DateTime $dateEdit;
    /** Сюда приходит либо "0", либо JSON типа: "[ {"id":32,"type":1}, {"id":35,"type":1}, {"id":77,"type":1} ]". 0 переводим в '' */
    public string $diagnose;
    /** Может прийти пустая строка, может просто строка, может HTML */
    public string $recommendation;
    /** @var ?positive-int Возможно null никогда не будет. Invoice ID (таблица invoice) */
    public ?int $invoiceId;
    /** @var ?positive-int Возможно null никогда не будет
     * {@see MedicalCard::admissionType} Тип приема
     * LEFT JOIN combo_manual_items ci ON ci.combo_manual_id = {$reasonId} AND ci.value = m.admission_type
     */
    public ?int $admissionTypeId;
    public ?float $weight;
    public ?float $temperature;
    /** /** @var ?positive-int Возможно null никогда не будет. Default: 0 (переводим в null). LEFT JOIN combo_manual_items ci2 ON ci2.combo_manual_id = 2 AND ci2.value = m.meet_result_id */
    public ?int $meetResultId;
    /** Может быть просто строка, а может HTML-блок */
    public string $description;
    /** @var ?positive-int Возможно null никогда не будет. Default: 0 - переводим в null.    LEFT JOIN admission ad ON ad.id = m.next_meet_id */
    public ?int $nextMeetId;
    /** @var ?positive-int Возможно null никогда не будет. Default: 0 - переводим в null */
    public ?int $userId;
    /** /** @var ?positive-int Возможно null никогда не будет. Default: 0 - переводим в null.
     * Может можно отдельно запрашивать его? */
    public ?int $creatorId;
    /** Default: 'active' */
    public Status $status;
    /** @var ?positive-int Возможно null никогда не будет. Default: 0 - переводим в null
     * Вроде это ID из модуля задач. Пока непонятно */
    public ?int $callingId;
    /** @var ?positive-int Возможно null никогда не будет. Default: 0 - переводим в null */
    public ?int $admissionId;
    /** Пример: "Анемия;\nАнорексия, кахексия;\nАтопия" */
    public string $diagnoseText;
    /** Пример: "Анемия (Окончательные);\nАнорексия, кахексия (Окончательные);\nАтопия (Окончательные)" */
    public string $diagnoseTypeText;
    /** @var ?positive-int Default: 0 - переводим в null. Нашел 6 клиник, где не есть 0 */
    public ?int $clinicId;

    /** @param array{
     *     id: numeric-string,
     *     patient_id: numeric-string,
     *     date_create: string,
     *     date_edit: ?string,
     *     diagnos: string,
     *     recomendation: string,
     *     invoice: ?string,
     *     admission_type: ?string,
     *     weight: ?string,
     *     temperature: ?string,
     *     meet_result_id: numeric-string,
     *     description: string,
     *     next_meet_id: numeric-string,
     *     doctor_id: numeric-string,
     *     creator_id: numeric-string,
     *     status: string,
     *     calling_id: numeric-string,
     *     admission_id: numeric-string,
     *     diagnos_text: ?string,
     *     diagnos_type_text: ?string,
     *     clinic_id: numeric-string,
     *     patient?: array
     *    } $originalDataArray
     * @throws VetmanagerApiGatewayException
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public static function fromApiResponseArray(array $originalDataArray): self
    {
        $instance = new self($originalDataArray);
        $instance->id = ApiInt::fromStringOrNull($originalDataArray['id'])->getPositiveInt();
        $instance->petId = ApiInt::fromStringOrNull($originalDataArray['patient_id'])->getPositiveInt();
        $instance->dateCreate = ApiDateTime::fromOnlyDateString($originalDataArray['date_create'])->getDateTimeOrThrow();
        $instance->dateEdit = ApiDateTime::fromOnlyDateString($originalDataArray['date_edit'])->getDateTimeOrThrow();
        $diagnose = ($originalDataArray['diagnos'] !== '0') ? $originalDataArray['diagnos'] : '';
        $instance->diagnose = ApiString::fromStringOrNull($diagnose)->getStringEvenIfNullGiven();
        $instance->recommendation = ApiString::fromStringOrNull($originalDataArray['recomendation'])->getStringEvenIfNullGiven();
        $instance->invoiceId = ApiInt::fromStringOrNull($originalDataArray['invoice'])->getPositiveIntOrNull();
        $instance->admissionTypeId = ApiInt::fromStringOrNull($originalDataArray['admission_type'])->getPositiveIntOrNull();
        $instance->weight = ApiFloat::fromStringOrNull($originalDataArray['weight'])->getNonZeroFloatOrNull();
        $instance->temperature = ApiFloat::fromStringOrNull($originalDataArray['temperature'])->getNonZeroFloatOrNull();
        $instance->meetResultId = ApiInt::fromStringOrNull($originalDataArray['meet_result_id'])->getPositiveIntOrNull();
        $instance->description = ApiString::fromStringOrNull($originalDataArray['description'])->getStringEvenIfNullGiven();
        $instance->nextMeetId = ApiInt::fromStringOrNull($originalDataArray['next_meet_id'])->getPositiveIntOrNull();
        $instance->userId = ApiInt::fromStringOrNull($originalDataArray['doctor_id'])->getPositiveIntOrNull();
        $instance->creatorId = ApiInt::fromStringOrNull($originalDataArray['creator_id'])->getPositiveIntOrNull();
        $instance->status = Status::from($originalDataArray['status']);
        $instance->callingId = ApiInt::fromStringOrNull($originalDataArray['calling_id'])->getPositiveIntOrNull();
        $instance->admissionId = ApiInt::fromStringOrNull($originalDataArray['admission_id'])->getPositiveIntOrNull();
        $instance->diagnoseText = ApiString::fromStringOrNull($originalDataArray['diagnos_text'])->getStringEvenIfNullGiven();
        $instance->diagnoseTypeText = ApiString::fromStringOrNull($originalDataArray['diagnos_type_text'])->getStringEvenIfNullGiven();
        $instance->clinicId = ApiInt::fromStringOrNull($originalDataArray['clinic_id'])->getPositiveIntOrNull();
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
            ['dateCreate', 'date_create'],
            ['dateEdit', 'date_edit'],
            ['diagnose', 'diagnos'],
            ['recommendation', 'recomendation'],
            ['invoiceId', 'invoice'],
            ['admissionTypeId', 'admission_type'],
            ['weight', 'weight'],
            ['temperature', 'temperature'],
            ['meetResultId', 'meet_result_id'],
            ['description', 'description'],
            ['nextMeetId', 'next_meet_id'],
            ['userId', 'doctor_id'],
            ['creatorId', 'creator_id'],
            ['status', 'status'],
            ['callingId', 'calling_id'],
            ['admissionId', 'admission_id'],
            ['diagnoseText', 'diagnos_text'],
            ['diagnoseTypeText', 'diagnos_type_text'],
            ['clinicId', 'clinic_id'],
        ))->toArray();
    }
}
