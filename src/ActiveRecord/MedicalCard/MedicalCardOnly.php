<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\MedicalCard;

use VetmanagerApiGateway\ActiveRecord\Pet\AbstractPet;
use VetmanagerApiGateway\DTO\MedicalCard\MedicalCardOnlyDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade;

///**
// * @property-read MedicalCardOnlyDto $originalDto
// * @property positive-int $id
// * @property positive-int $petId
// * @property DateTime $dateCreate
// * @property DateTime $dateEdit
// * @property string $diagnose Сюда приходит либо "0", либо JSON типа: "[ {"id":32,"type":1}, {"id":35,"type":1}, {"id":77,"type":1} ]". 0 переводим в ''
// * @property string $recommendation Может прийти пустая строка, может просто строка, может HTML
// * @property ?positive-int $invoiceId Возможно null никогда не будет. Invoice ID (таблица invoice)
// * @property ?positive-int $admissionTypeId {@see AbstractMedicalCard::admissionType} Тип приема.    LEFT JOIN combo_manual_items ci ON ci.combo_manual_id = {$reasonId} AND ci.value = m.admission_type
// * @property ?float $weight
// * @property ?float $temperature
// * @property ?positive-int $meetResultId Возможно null никогда не будет. Default: 0 (переводим в null). LEFT JOIN combo_manual_items ci2 ON ci2.combo_manual_id = 2 AND ci2.value = m.meet_result_id
// * @property string $description Может быть просто строка, а может HTML-блок
// * @property ?positive-int $nextMeetId Возможно null никогда не будет. Default: 0 - переводим в null.    LEFT JOIN admission ad ON ad.id = m.next_meet_id
// * @property ?positive-int $userId Возможно null никогда не будет. Default: 0 - переводим в null
// * @property ?positive-int $creatorId Возможно null никогда не будет. Default: 0 - переводим в null. Может можно отдельно запрашивать его?
// * @property StatusEnum $status Default: 'active'
// * @property ?positive-int $callingId Вроде это ID из модуля задач. Пока непонятно
// * @property ?positive-int $admissionId Возможно null никогда не будет
// * @property string $diagnoseText Пример: "Анемия;\nАнорексия, кахексия;\nАтопия"
// * @property string $diagnoseTypeText Пример: "Анемия (Окончательные);\nАнорексия, кахексия (Окончательные);\nАтопия (Окончательные)"
// * @property ?positive-int $clinicId Может прийти null. Нашел 6 клиник, где не указано
// * @property-read array{
// *     id: numeric-string,
// *     patient_id: numeric-string,
// *     date_create: string,
// *     date_edit: ?string,
// *     diagnos: string,
// *     recomendation: string,
// *     invoice: ?string,
// *     admission_type: ?string,
// *     weight: ?string,
// *     temperature: ?string,
// *     meet_result_id: numeric-string,
// *     description: string,
// *     next_meet_id: numeric-string,
// *     doctor_id: numeric-string,
// *     creator_id: numeric-string,
// *     status: string,
// *     calling_id: numeric-string,
// *     admission_id: numeric-string,
// *     diagnos_text: ?string,
// *     diagnos_type_text: ?string,
// *     clinic_id: numeric-string,
// *     patient: array{
// *          id: numeric-string,
// *          owner_id: ?numeric-string,
// *          type_id: ?numeric-string,
// *          alias: string,
// *          sex: ?string,
// *          date_register: string,
// *          birthday: ?string,
// *          note: string,
// *          breed_id: ?numeric-string,
// *          old_id: ?numeric-string,
// *          color_id: ?numeric-string,
// *          deathnote: ?string,
// *          deathdate: ?string,
// *          chip_number: string,
// *          lab_number: string,
// *          status: string,
// *          picture: ?string,
// *          weight: ?string,
// *          edit_date: string
// *          }
// *      } $originalDataArray
// * @property-read PetOnly $pet
// * @property-read ?Clinic $clinic
// * @property-read ?bool $isOnlineSigningUpAvailableForClinic Придет null, если clinic_id в БД не указан (очень редкий случай - 6 клиник)
// * @property-read ?AdmissionOnly $admission
// * @property-read ?AdmissionOnly $nextMeet
// * @property-read ?ComboManualItemOnly $admissionType
// * @property-read ?ComboManualItemOnly $meetResult
// * @property-read ?InvoiceOnly $invoice
// * @property-read ?UserOnly $user
// */
final class MedicalCardOnly extends AbstractMedicalCard
{
    public static function getDtoClass(): string
    {
        return MedicalCardOnlyDto::class;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getPet(): AbstractPet
    {
        return (new Facade\Pet($this->activeRecordFactory))->getById($this->getPetId());
    }
}
