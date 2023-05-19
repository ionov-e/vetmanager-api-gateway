<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use DateTime;
use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\Hydrator\ApiDateTime;
use VetmanagerApiGateway\Hydrator\ApiFloat;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;
use VetmanagerApiGateway\DTO\Enum\MedicalCard\Status;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/**
 * @property-read ?Clinic clinic
 * @property-read bool isOnlineSigningUpAvailableForClinic
 * @property-read ?AdmissionFromGetById admission
 * @property-read ?AdmissionFromGetById nextMeet
 * @property-read ?ComboManualItem admissionType
 * @property-read ?ComboManualItem meetResult
 * @property-read ?Invoice invoice
 * @property-read ?User user
 */
final class MedicalCard extends AbstractActiveRecord implements AllGetRequestsInterface
{

    use AllGetRequestsTrait;

    /** @var positive-int */
    public int $id;
    public DateTime $dateCreate;
    public DateTime $dateEdit;
    /** Сюда приходит либо "0", либо JSON типа: "[ {"id":32,"type":1}, {"id":35,"type":1}, {"id":77,"type":1} ]". 0 переводим в '' */
    public string $diagnose;
    /** Может прийти пустая строка, может просто строка, может HTML */
    public string $recommendation;
    /** /** @var positive-int|null Возможно null никогда не будет. Invoice ID (таблица invoice) */
    public ?int $invoiceId;
    /** @var positive-int|null Возможно null никогда не будет
     * {@see MedicalCard::admissionType} Тип приема
     * LEFT JOIN combo_manual_items ci ON ci.combo_manual_id = {$reasonId} AND ci.value = m.admission_type
     */
    public ?int $admissionTypeId;
    public ?float $weight;
    public ?float $temperature;
    /** /** @var positive-int|null Возможно null никогда не будет. Default: 0 (переводим в null). LEFT JOIN combo_manual_items ci2 ON ci2.combo_manual_id = 2 AND ci2.value = m.meet_result_id */
    public ?int $meetResultId;
    /** Может быть просто строка, а может HTML-блок */
    public string $description;
    /** @var positive-int|null Возможно null никогда не будет. Default: 0 - переводим в null.    LEFT JOIN admission ad ON ad.id = m.next_meet_id */
    public ?int $nextMeetId;
    /** @var positive-int|null Возможно null никогда не будет. Default: 0 - переводим в null */
    public ?int $userId;
    /** /** @var positive-int|null Возможно null никогда не будет. Default: 0 - переводим в null.
     * Может можно отдельно запрашивать его? */
    public ?int $creatorId;
    /** Default: 'active' */
    public Status $status;
    /** @var positive-int|null Возможно null никогда не будет. Default: 0 - переводим в null
     * Вроде это ID из модуля задач. Пока непонятно */
    public ?int $callingId;
    /** @var positive-int|null Возможно null никогда не будет. Default: 0 - переводим в null */
    public ?int $admissionId;
    /** Пример: "Анемия;\nАнорексия, кахексия;\nАтопия" */
    public string $diagnoseText;
    /** Пример: "Анемия (Окончательные);\nАнорексия, кахексия (Окончательные);\nАтопия (Окончательные)" */
    public string $diagnoseTypeText;
    /** @var positive-int|null Возможно null никогда не будет. Default: 0 - переводим в null */
    public ?int $clinicId;
    public Pet $pet;

    /** @param array{
     *     "id": string,
     *     "patient_id": string,
     *     "date_create": string,
     *     "date_edit": ?string,
     *     "diagnos": string,
     *     "recomendation": string,
     *     "invoice": ?string,
     *     "admission_type": ?string,
     *     "weight": ?string,
     *     "temperature": ?string,
     *     "meet_result_id": string,
     *     "description": string,
     *     "next_meet_id": string,
     *     "doctor_id": string,
     *     "creator_id": string,
     *     "status": string,
     *     "calling_id": string,
     *     "admission_id": string,
     *     "diagnos_text": ?string,
     *     "diagnos_type_text": ?string,
     *     "clinic_id": string,
     *     "patient": array{
     *          "id": string,
     *          "owner_id": ?string,
     *          "type_id": ?string,
     *          "alias": string,
     *          "sex": ?string,
     *          "date_register": string,
     *          "birthday": ?string,
     *          "note": string,
     *          "breed_id": ?string,
     *          "old_id": ?string,
     *          "color_id": ?string,
     *          "deathnote": ?string,
     *          "deathdate": ?string,
     *          "chip_number": string,
     *          "lab_number": string,
     *          "status": string,
     *          "picture": ?string,
     *          "weight": ?string,
     *          "edit_date": string,
     *          }
     *      } $originalData
     * @throws VetmanagerApiGatewayException
     */
    public function __construct(ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = ApiInt::fromStringOrNull($originalData['id'])->positiveInt;
        $this->dateCreate = ApiDateTime::fromOnlyDateString($originalData['date_create'])->dateTime;
        $this->dateEdit = ApiDateTime::fromOnlyDateString($originalData['date_edit'])->dateTime;
        $diagnose = ($originalData['diagnos'] !== '0') ? $originalData['diagnos'] : '';
        $this->diagnose = ApiString::fromStringOrNull($diagnose)->string;
        $this->recommendation = ApiString::fromStringOrNull($originalData['recomendation'])->string;
        $this->invoiceId = ApiInt::fromStringOrNull($originalData['invoice'])->positiveIntOrNull;
        $this->admissionTypeId = ApiInt::fromStringOrNull($originalData['admission_type'])->positiveIntOrNull;
        $this->weight = ApiFloat::fromStringOrNull($originalData['weight'])->floatOrNull;
        $this->temperature = ApiFloat::fromStringOrNull($originalData['temperature'])->floatOrNull;
        $this->meetResultId = ApiInt::fromStringOrNull($originalData['meet_result_id'])->positiveIntOrNull;
        $this->description = ApiString::fromStringOrNull($originalData['description'])->string;
        $this->nextMeetId = ApiInt::fromStringOrNull($originalData['next_meet_id'])->positiveIntOrNull;
        $this->userId = ApiInt::fromStringOrNull($originalData['doctor_id'])->positiveIntOrNull;
        $this->creatorId = ApiInt::fromStringOrNull($originalData['creator_id'])->positiveIntOrNull;
        $this->status = Status::from($originalData['status']);
        $this->callingId = ApiInt::fromStringOrNull($originalData['calling_id'])->positiveIntOrNull;
        $this->admissionId = ApiInt::fromStringOrNull($originalData['admission_id'])->positiveIntOrNull;
        $this->diagnoseText = ApiString::fromStringOrNull($originalData['diagnos_text'])->string;
        $this->diagnoseTypeText = ApiString::fromStringOrNull($originalData['diagnos_type_text'])->string;
        $this->clinicId = ApiInt::fromStringOrNull($originalData['clinic_id'])->positiveIntOrNull;
        $this->pet = Pet::fromSingleDtoArrayUsingBasicDto($this->apiGateway, $originalData['patient']);
    }

    /** @return ApiModel::MedicalCard */
    public static function getApiModel(): ApiModel
    {
        return ApiModel::MedicalCard;
    }

    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'clinic' => $this->clinicId ? Clinic::getById($this->apiGateway, $this->clinicId) : null,
            'isOnlineSigningUpAvailableForClinic' => Property::isOnlineSigningUpAvailableForClinic($this->apiGateway, $this->clinicId),
            'admission' => $this->admissionId ? Admission::getById($this->apiGateway, $this->admissionId) : null,
            'nextMeet' => $this->nextMeetId ? Admission::getById($this->apiGateway, $this->nextMeetId) : null,
            'admissionType' => $this->admissionTypeId ? ComboManualItem::getByAdmissionTypeId($this->apiGateway, $this->admissionTypeId) : null,
            'meetResult' => $this->meetResultId ? ComboManualItem::getByAdmissionResultId($this->apiGateway, $this->meetResultId) : null,
            'invoice' => $this->invoiceId ? Invoice::getById($this->apiGateway, $this->invoiceId) : null,
            'user' => $this->userId ? User::getById($this->apiGateway, $this->userId) : null,
            default => $this->originalDto->$name
        };
    }
}
