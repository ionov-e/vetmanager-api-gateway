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

/** @psalm-suppress PropertyNotSetInConstructor, RedundantPropertyInitializationCheck - одобрено в доках PSALM для этого случая */
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
    /** @var ?positive-int Возможно null никогда не будет. Default: 0 - переводим в null */
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
     *    } $originalData
     * @throws VetmanagerApiGatewayException
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public static function fromApiResponseArray(array $originalData): self
    {
        $instance = new self();
        $instance->id = ApiInt::fromStringOrNull($originalData['id'])->positiveInt;
        $instance->petId = ApiInt::fromStringOrNull($originalData['patient_id'])->positiveInt;
        $instance->dateCreate = ApiDateTime::fromOnlyDateString($originalData['date_create'])->dateTime;
        $instance->dateEdit = ApiDateTime::fromOnlyDateString($originalData['date_edit'])->dateTime;
        $diagnose = ($originalData['diagnos'] !== '0') ? $originalData['diagnos'] : '';
        $instance->diagnose = ApiString::fromStringOrNull($diagnose)->string;
        $instance->recommendation = ApiString::fromStringOrNull($originalData['recomendation'])->string;
        $instance->invoiceId = ApiInt::fromStringOrNull($originalData['invoice'])->positiveIntOrNull;
        $instance->admissionTypeId = ApiInt::fromStringOrNull($originalData['admission_type'])->positiveIntOrNull;
        $instance->weight = ApiFloat::fromStringOrNull($originalData['weight'])->floatOrNull;
        $instance->temperature = ApiFloat::fromStringOrNull($originalData['temperature'])->floatOrNull;
        $instance->meetResultId = ApiInt::fromStringOrNull($originalData['meet_result_id'])->positiveIntOrNull;
        $instance->description = ApiString::fromStringOrNull($originalData['description'])->string;
        $instance->nextMeetId = ApiInt::fromStringOrNull($originalData['next_meet_id'])->positiveIntOrNull;
        $instance->userId = ApiInt::fromStringOrNull($originalData['doctor_id'])->positiveIntOrNull;
        $instance->creatorId = ApiInt::fromStringOrNull($originalData['creator_id'])->positiveIntOrNull;
        $instance->status = Status::from($originalData['status']);
        $instance->callingId = ApiInt::fromStringOrNull($originalData['calling_id'])->positiveIntOrNull;
        $instance->admissionId = ApiInt::fromStringOrNull($originalData['admission_id'])->positiveIntOrNull;
        $instance->diagnoseText = ApiString::fromStringOrNull($originalData['diagnos_text'])->string;
        $instance->diagnoseTypeText = ApiString::fromStringOrNull($originalData['diagnos_type_text'])->string;
        $instance->clinicId = ApiInt::fromStringOrNull($originalData['clinic_id'])->positiveIntOrNull;
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
