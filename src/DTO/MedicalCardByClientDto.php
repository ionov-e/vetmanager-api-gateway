<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use DateTime;
use VetmanagerApiGateway\DO\FullName;
use VetmanagerApiGateway\DTO\Enum\MedicalCard\Status;
use VetmanagerApiGateway\DTO\Enum\Pet\Sex;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Hydrator\ApiBool;
use VetmanagerApiGateway\Hydrator\ApiDateTime;
use VetmanagerApiGateway\Hydrator\ApiFloat;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;
use VetmanagerApiGateway\Hydrator\DtoPropertyList;

/** @psalm-suppress PropertyNotSetInConstructor, RedundantPropertyInitializationCheck - одобрено в доках PSALM для этого случая */
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
    public Status $status;
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
     * {@see MedicalCard::admissionType} Тип приема
     * LEFT JOIN combo_manual_items ci ON ci.combo_manual_id = {$reasonId} AND ci.value = m.admission_type
     */
    public ?int $admissionTypeId;
    /** @var positive-int */
    public int $petId;
    public string $petAlias;
    /** Дата без времени */
    public ?DateTime $petBirthday;
    public Sex $petSex;
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
     *    } $originalData
     * @throws VetmanagerApiGatewayException
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public static function fromApiResponseArray(array $originalData): self
    {
        $instance = new self();
        $instance->id = ApiInt::fromStringOrNull($originalData['medical_card_id'])->positiveInt;
        $instance->dateEdit = ApiDateTime::fromOnlyDateString($originalData['date_edit'])->dateTimeOrNull;
        $diagnose = ($originalData['diagnos'] !== '0') ? $originalData['diagnos'] : '';
        $instance->diagnose = ApiString::fromStringOrNull($diagnose)->string;
        $instance->userId = ApiInt::fromStringOrNull($originalData['doctor_id'])->positiveIntOrNull;
        $instance->status = Status::from($originalData['medical_card_status']);
        $instance->description = ApiString::fromStringOrNull($originalData['healing_process'])->string;
        $instance->recommendation = ApiString::fromStringOrNull($originalData['recomendation'])->string;
        $instance->weight = ApiFloat::fromStringOrNull($originalData['weight'])->floatOrNull;
        $instance->temperature = ApiFloat::fromStringOrNull($originalData['temperature'])->floatOrNull;
        $instance->meetResultId = ApiInt::fromStringOrNull($originalData['meet_result_id'])->positiveIntOrNull;
        $instance->admissionTypeId = ApiInt::fromStringOrNull($originalData['admission_type'])->positiveIntOrNull;
        $instance->petId = ApiInt::fromStringOrNull($originalData['pet_id'])->positiveInt;
        $instance->petAlias = ApiString::fromStringOrNull($originalData['alias'])->string;
        $instance->petBirthday = ApiDateTime::fromOnlyDateString($originalData['birthday'])->dateTimeOrNull;
        $instance->petSex = $originalData['sex'] ? Sex::from($originalData['sex']) : Sex::Unknown;
        $instance->petNote = ApiString::fromStringOrNull($originalData['note'])->string;
        $instance->petTypeTitle = ApiString::fromStringOrNull($originalData['pet_type'])->string;
        $instance->petBreedTitle = ApiString::fromStringOrNull($originalData['breed'])->string;
        $instance->clientId = ApiInt::fromStringOrNull($originalData['client_id'])->positiveInt;
        $instance->ownerFullName = new FullName($originalData['first_name'], $originalData['middle_name'], $originalData['last_name']);
        $instance->ownerPhone = ApiString::fromStringOrNull($originalData['phone'])->string;
        $instance->userLogin = ApiString::fromStringOrNull($originalData['doctor_nickname'])->string;
        $instance->userFullName = new FullName($originalData['doctor_first_name'], $originalData['doctor_middle_name'], $originalData['doctor_last_name']);
        $instance->isEditable = ApiBool::fromStringOrNull($originalData['editable'])->bool;
        $instance->meetResultTitle = ApiString::fromStringOrNull($originalData['meet_result_title'])->string;
        $instance->admissionTypeTitle = ApiString::fromStringOrNull($originalData['admission_type_title'])->string;
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
            ['dateEdit', 'date_edit'],
            ['diagnose', 'diagnos'],
            ['userId', 'doctor_id'],
            ['status', 'medical_card_status'],
            ['description', 'healing_process'],
            ['recommendation', 'recomendation'],
            ['weight', 'weight'],
            ['temperature', 'temperature'],
            ['meetResultId', 'meet_result_id'],
            ['admissionTypeId', 'admission_type'],
            ['petId', 'pet_id'],
            ['petAlias', 'alias'],
            ['petBirthday', 'birthday'],
            ['petSex', 'sex'],
            ['petNote', 'note'],
            ['petTypeTitle', 'pet_type'],
            ['petBreedTitle', 'breed'],
            ['clientId', 'client_id'],
            ['ownerPhone', 'phone'],
            ['userLogin', 'doctor_nickname'],
            ['userFullName', 'doctor_middle_name'],
            ['isEditable', 'editable'],
            ['meetResultTitle', 'meet_result_title'],
            ['admissionTypeTitle', 'admission_type_title'],
        ))->toArray();
    }
}
