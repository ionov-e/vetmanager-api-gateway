<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\MedicalCard;

use DateTime;
use VetmanagerApiGateway\ActiveRecord\MedicalCard\AbstractMedicalCard;
use VetmanagerApiGateway\ApiDataInterpreter\ToDateTime;
use VetmanagerApiGateway\ApiDataInterpreter\ToFloat;
use VetmanagerApiGateway\ApiDataInterpreter\ToInt;
use VetmanagerApiGateway\ApiDataInterpreter\ToString;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class MedicalCardOnlyDto extends AbstractDTO
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
     * {@see AbstractMedicalCard::admissionType} Тип приема
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
    public StatusEnum $status;
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
        $instance->id = ToInt::fromStringOrNull($originalDataArray['id'])->getPositiveIntOrThrow();
        $instance->petId = ToInt::fromStringOrNull($originalDataArray['patient_id'])->getPositiveIntOrThrow();
        $instance->dateCreate = ToDateTime::fromOnlyDateString($originalDataArray['date_create'])->getDateTimeOrThrow();
        $instance->dateEdit = ToDateTime::fromOnlyDateString($originalDataArray['date_edit'])->getDateTimeOrThrow();
        $diagnose = ($originalDataArray['diagnos'] !== '0') ? $originalDataArray['diagnos'] : '';
        $instance->diagnose = ToString::fromStringOrNull($diagnose)->getStringEvenIfNullGiven();
        $instance->recommendation = ToString::fromStringOrNull($originalDataArray['recomendation'])->getStringEvenIfNullGiven();
        $instance->invoiceId = ToInt::fromStringOrNull($originalDataArray['invoice'])->getPositiveIntOrNullOrThrowIfNegative();
        $instance->admissionTypeId = ToInt::fromStringOrNull($originalDataArray['admission_type'])->getPositiveIntOrNullOrThrowIfNegative();
        $instance->weight = ToFloat::fromStringOrNull($originalDataArray['weight'])->getNonZeroFloatOrNull();
        $instance->temperature = ToFloat::fromStringOrNull($originalDataArray['temperature'])->getNonZeroFloatOrNull();
        $instance->meetResultId = ToInt::fromStringOrNull($originalDataArray['meet_result_id'])->getPositiveIntOrNullOrThrowIfNegative();
        $instance->description = ToString::fromStringOrNull($originalDataArray['description'])->getStringEvenIfNullGiven();
        $instance->nextMeetId = ToInt::fromStringOrNull($originalDataArray['next_meet_id'])->getPositiveIntOrNullOrThrowIfNegative();
        $instance->userId = ToInt::fromStringOrNull($originalDataArray['doctor_id'])->getPositiveIntOrNullOrThrowIfNegative();
        $instance->creatorId = ToInt::fromStringOrNull($originalDataArray['creator_id'])->getPositiveIntOrNullOrThrowIfNegative();
        $instance->status = StatusEnum::from($originalDataArray['status']);
        $instance->callingId = ToInt::fromStringOrNull($originalDataArray['calling_id'])->getPositiveIntOrNullOrThrowIfNegative();
        $instance->admissionId = ToInt::fromStringOrNull($originalDataArray['admission_id'])->getPositiveIntOrNullOrThrowIfNegative();
        $instance->diagnoseText = ToString::fromStringOrNull($originalDataArray['diagnos_text'])->getStringEvenIfNullGiven();
        $instance->diagnoseTypeText = ToString::fromStringOrNull($originalDataArray['diagnos_type_text'])->getStringEvenIfNullGiven();
        $instance->clinicId = ToInt::fromStringOrNull($originalDataArray['clinic_id'])->getPositiveIntOrNullOrThrowIfNegative();
        return $instance;
    }
}
