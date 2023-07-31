<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\MedicalCardByClient;

use DateTime;
use VetmanagerApiGateway\ActiveRecord\MedicalCard\AbstractMedicalCard;
use VetmanagerApiGateway\ApiDataInterpreter\ToBool;
use VetmanagerApiGateway\ApiDataInterpreter\ToDateTime;
use VetmanagerApiGateway\ApiDataInterpreter\ToFloat;
use VetmanagerApiGateway\ApiDataInterpreter\ToInt;
use VetmanagerApiGateway\ApiDataInterpreter\ToString;
use VetmanagerApiGateway\DO\FullName;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\DTO\MedicalCard\StatusEnum;
use VetmanagerApiGateway\DTO\Pet\SexEnum;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

final class MedicalCardByClientDto extends AbstractDTO
{
    /** @var positive-int */
    public int $id;
    public ?DateTime $dateEdit;
    /** Сюда приходит либо "0", либо JSON типа: "[ {"id":32,"type":1}, {"id":35,"type":1}, {"id":77,"type":1} ]". 0 переводим в '' */
    public string $diagnose;
    /** @var ?positive-int Default: 0 - переводим в null */
    public ?int $userId;
    /** Default: 'active' */
    public StatusEnum $status;
    /** Может быть просто строка, а может HTML-блок */
    public string $description;
    /** Может прийти пустая строка, может просто строка, может HTML */
    public string $recommendation;
    public ?float $weight;
    public ?float $temperature;
    /** @var ?positive-int Default: 0 - переводим в null
     * LEFT JOIN combo_manual_items ci2 ON ci2.combo_manual_id = 2 AND ci2.value = m.meet_result_id. 0 переводим в null
     */
    public ?int $meetResultId;
    /** /** @var ?positive-int Default: 0 - переводим в null
     * {@see AbstractMedicalCard::admissionType} Тип приема
     * LEFT JOIN combo_manual_items ci ON ci.combo_manual_id = {$reasonId} AND ci.value = m.admission_type
     */
    public ?int $admissionTypeId;
    /** @var positive-int */
    public int $petId;
    public string $petAlias;
    /** Дата без времени */
    public ?DateTime $petBirthday;
    public SexEnum $petSex;
    public string $petNote;
    public string $petTypeTitle;
    public string $petBreedTitle;
    /** @var ?positive-int Default: 0 - переводим в null. Не уверен, что вообще можем получить 0 или null */
    public ?int $clientId;
    public FullName $ownerFullName;
    public string $ownerPhone;
    public string $userLogin;
    public FullName $userFullName;
    /** Будет False, если в таблице special_studies_medcard_data будет хоть одна запись с таким же medcard_id {@see self::id}  */
    public bool $isEditable;
    /** Пример: "Повторный прием"
     *
     * В таблице combo_manual_items ищет кортеж с combo_manual_id = 2 и value = {@see self::meetResultId}. Из строки возвращается title
     */
    public string $meetResultTitle;
    /** Пример: "Вакцинация", "Хирургия", "Первичный" или "Вторичный"
     *
     * В таблице combo_manual_items ищет строку с id = {@see self::admissionType} и возвращает значение из столбца title. */
    public string $admissionTypeTitle;

    /** @param array{
     *     medical_card_id: numeric-string,
     *     date_edit: ?string,
     *     diagnos: string,
     *     doctor_id: numeric-string,
     *     medical_card_status: string,
     *     healing_process: ?string,
     *     recomendation: string,
     *     weight: ?string,
     *     temperature: ?string,
     *     meet_result_id: numeric-string,
     *     admission_type: ?string,
     *     pet_id: numeric-string,
     *     alias: string,
     *     birthday: ?string,
     *     sex: string,
     *     note: string,
     *     pet_type: string,
     *     breed: string,
     *     client_id: numeric-string,
     *     first_name: string,
     *     last_name: string,
     *     middle_name: string,
     *     phone: string,
     *     doctor_nickname: string,
     *     doctor_first_name: string,
     *     doctor_last_name: string,
     *     doctor_middle_name: string,
     *     editable: string,
     *     meet_result_title: string,
     *     admission_type_title: string
     *    } $originalDataArray
     * @throws VetmanagerApiGatewayException
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public static function fromApiResponseArray(array $originalDataArray): self
    {
        $instance = new self($originalDataArray);
        $instance->id = ToInt::fromStringOrNull($originalDataArray['medical_card_id'])->getPositiveInt();
        $instance->dateEdit = ToDateTime::fromOnlyDateString($originalDataArray['date_edit'])->getDateTimeOrThrow();
        $diagnose = ($originalDataArray['diagnos'] !== '0') ? $originalDataArray['diagnos'] : '';
        $instance->diagnose = ToString::fromStringOrNull($diagnose)->getStringEvenIfNullGiven();
        $instance->userId = ToInt::fromStringOrNull($originalDataArray['doctor_id'])->getPositiveIntOrNull();
        $instance->status = StatusEnum::from($originalDataArray['medical_card_status']);
        $instance->description = ToString::fromStringOrNull($originalDataArray['healing_process'])->getStringEvenIfNullGiven();
        $instance->recommendation = ToString::fromStringOrNull($originalDataArray['recomendation'])->getStringEvenIfNullGiven();
        $instance->weight = ToFloat::fromStringOrNull($originalDataArray['weight'])->getNonZeroFloatOrNull();
        $instance->temperature = ToFloat::fromStringOrNull($originalDataArray['temperature'])->getNonZeroFloatOrNull();
        $instance->meetResultId = ToInt::fromStringOrNull($originalDataArray['meet_result_id'])->getPositiveIntOrNull();
        $instance->admissionTypeId = ToInt::fromStringOrNull($originalDataArray['admission_type'])->getPositiveIntOrNull();
        $instance->petId = ToInt::fromStringOrNull($originalDataArray['pet_id'])->getPositiveInt();
        $instance->petAlias = ToString::fromStringOrNull($originalDataArray['alias'])->getStringEvenIfNullGiven();
        $instance->petBirthday = ToDateTime::fromOnlyDateString($originalDataArray['birthday'])->getDateTimeOrThrow();
        $instance->petSex = $originalDataArray['sex'] ? SexEnum::from($originalDataArray['sex']) : SexEnum::Unknown;
        $instance->petNote = ToString::fromStringOrNull($originalDataArray['note'])->getStringEvenIfNullGiven();
        $instance->petTypeTitle = ToString::fromStringOrNull($originalDataArray['pet_type'])->getStringEvenIfNullGiven();
        $instance->petBreedTitle = ToString::fromStringOrNull($originalDataArray['breed'])->getStringEvenIfNullGiven();
        $instance->clientId = ToInt::fromStringOrNull($originalDataArray['client_id'])->getPositiveInt();
        $instance->ownerFullName = new FullName($originalDataArray['first_name'], $originalDataArray['middle_name'], $originalDataArray['last_name']);
        $instance->ownerPhone = ToString::fromStringOrNull($originalDataArray['phone'])->getStringEvenIfNullGiven();
        $instance->userLogin = ToString::fromStringOrNull($originalDataArray['doctor_nickname'])->getStringEvenIfNullGiven();
        $instance->userFullName = new FullName($originalDataArray['doctor_first_name'], $originalDataArray['doctor_middle_name'], $originalDataArray['doctor_last_name']);
        $instance->isEditable = ToBool::fromStringOrNull($originalDataArray['editable'])->getBoolOrThrowIfNull();
        $instance->meetResultTitle = ToString::fromStringOrNull($originalDataArray['meet_result_title'])->getStringEvenIfNullGiven();
        $instance->admissionTypeTitle = ToString::fromStringOrNull($originalDataArray['admission_type_title'])->getStringEvenIfNullGiven();
        return $instance;
    }
}
