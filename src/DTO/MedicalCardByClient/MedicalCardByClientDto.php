<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\MedicalCardByClient;

use DateTime;
use VetmanagerApiGateway\ActiveRecord\MedicalCard\AbstractMedicalCard;
use VetmanagerApiGateway\DO\FullName;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\DTO\MedicalCard\StatusEnum;
use VetmanagerApiGateway\DTO\Pet\SexEnum;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Hydrator\ApiBool;
use VetmanagerApiGateway\Hydrator\ApiDateTime;
use VetmanagerApiGateway\Hydrator\ApiFloat;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;
use VetmanagerApiGateway\Hydrator\DtoPropertyList;

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
        $instance->id = ApiInt::fromStringOrNull($originalDataArray['medical_card_id'])->getPositiveInt();
        $instance->dateEdit = ApiDateTime::fromOnlyDateString($originalDataArray['date_edit'])->getDateTimeOrThrow();
        $diagnose = ($originalDataArray['diagnos'] !== '0') ? $originalDataArray['diagnos'] : '';
        $instance->diagnose = ApiString::fromStringOrNull($diagnose)->getStringEvenIfNullGiven();
        $instance->userId = ApiInt::fromStringOrNull($originalDataArray['doctor_id'])->getPositiveIntOrNull();
        $instance->status = StatusEnum::from($originalDataArray['medical_card_status']);
        $instance->description = ApiString::fromStringOrNull($originalDataArray['healing_process'])->getStringEvenIfNullGiven();
        $instance->recommendation = ApiString::fromStringOrNull($originalDataArray['recomendation'])->getStringEvenIfNullGiven();
        $instance->weight = ApiFloat::fromStringOrNull($originalDataArray['weight'])->getNonZeroFloatOrNull();
        $instance->temperature = ApiFloat::fromStringOrNull($originalDataArray['temperature'])->getNonZeroFloatOrNull();
        $instance->meetResultId = ApiInt::fromStringOrNull($originalDataArray['meet_result_id'])->getPositiveIntOrNull();
        $instance->admissionTypeId = ApiInt::fromStringOrNull($originalDataArray['admission_type'])->getPositiveIntOrNull();
        $instance->petId = ApiInt::fromStringOrNull($originalDataArray['pet_id'])->getPositiveInt();
        $instance->petAlias = ApiString::fromStringOrNull($originalDataArray['alias'])->getStringEvenIfNullGiven();
        $instance->petBirthday = ApiDateTime::fromOnlyDateString($originalDataArray['birthday'])->getDateTimeOrThrow();
        $instance->petSex = $originalDataArray['sex'] ? SexEnum::from($originalDataArray['sex']) : SexEnum::Unknown;
        $instance->petNote = ApiString::fromStringOrNull($originalDataArray['note'])->getStringEvenIfNullGiven();
        $instance->petTypeTitle = ApiString::fromStringOrNull($originalDataArray['pet_type'])->getStringEvenIfNullGiven();
        $instance->petBreedTitle = ApiString::fromStringOrNull($originalDataArray['breed'])->getStringEvenIfNullGiven();
        $instance->clientId = ApiInt::fromStringOrNull($originalDataArray['client_id'])->getPositiveInt();
        $instance->ownerFullName = new FullName($originalDataArray['first_name'], $originalDataArray['middle_name'], $originalDataArray['last_name']);
        $instance->ownerPhone = ApiString::fromStringOrNull($originalDataArray['phone'])->getStringEvenIfNullGiven();
        $instance->userLogin = ApiString::fromStringOrNull($originalDataArray['doctor_nickname'])->getStringEvenIfNullGiven();
        $instance->userFullName = new FullName($originalDataArray['doctor_first_name'], $originalDataArray['doctor_middle_name'], $originalDataArray['doctor_last_name']);
        $instance->isEditable = ApiBool::fromStringOrNull($originalDataArray['editable'])->getBoolOrThrowIfNull();
        $instance->meetResultTitle = ApiString::fromStringOrNull($originalDataArray['meet_result_title'])->getStringEvenIfNullGiven();
        $instance->admissionTypeTitle = ApiString::fromStringOrNull($originalDataArray['admission_type_title'])->getStringEvenIfNullGiven();
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
