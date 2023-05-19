<?php

/** @noinspection PhpUnnecessaryCurlyVarSyntaxInspection */

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use DateTime;
use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\FullName;
use VetmanagerApiGateway\DTO\Enum\MedicalCard\Status;
use VetmanagerApiGateway\DTO\Enum\Pet\Sex;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;
use VetmanagerApiGateway\Hydrator\ApiBool;
use VetmanagerApiGateway\Hydrator\ApiDateTime;
use VetmanagerApiGateway\Hydrator\ApiFloat;
use VetmanagerApiGateway\Hydrator\ApiInt;
use VetmanagerApiGateway\Hydrator\ApiString;

/**
 * @property-read ?ActiveRecord\ComboManualItem admissionType
 * @property-read ?ActiveRecord\ComboManualItem meetResult
 * @property-read ?ActiveRecord\Client client
 * @property-read ActiveRecord\Pet pet
 * @property-read ?ActiveRecord\User user
 */
final class MedicalCardsByClient extends AbstractActiveRecord
{


    /** @var positive-int */

    public int $id;
    public ?DateTime $dateEdit;
    /** Сюда приходит либо "0", либо JSON типа: "[ {"id":32,"type":1}, {"id":35,"type":1}, {"id":77,"type":1} ]". 0 переводим в '' */
    public string $diagnose;
    /** @var positive-int|null Default: 0 - переводим в null */
    public ?int $userId;
    /** Default: 'active' */
    public Status $status;
    /** Может быть просто строка, а может HTML-блок */
    public string $description;
    /** Может прийти пустая строка, может просто строка, может HTML */
    public string $recommendation;
    public ?float $weight;
    public ?float $temperature;
    /** @var positive-int|null Default: 0 - переводим в null
     * LEFT JOIN combo_manual_items ci2 ON ci2.combo_manual_id = 2 AND ci2.value = m.meet_result_id. 0 переводим в null
     */
    public ?int $meetResultId;
    /** /** @var positive-int|null Default: 0 - переводим в null
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
    /** @var positive-int|null Default: 0 - переводим в null. Не уверен, что вообще можем получить 0 или null */
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
     *     "medical_card_id": string,
     *     "date_edit": ?string,
     *     "diagnos": string,
     *     "doctor_id": string,
     *     "medical_card_status": string,
     *     "healing_process": ?string,
     *     "recomendation": string,
     *     "weight": ?string,
     *     "temperature": ?string,
     *     "meet_result_id": string,
     *     "admission_type": ?string,
     *     "pet_id": string,
     *     "alias": string,
     *     "birthday": ?string,
     *     "sex": string,
     *     "note": string,
     *     "pet_type": string,
     *     "breed": string,
     *     "client_id": string,
     *     "first_name": string,
     *     "last_name": string,
     *     "middle_name": string,
     *     "phone": string,
     *     "doctor_nickname": string,
     *     "doctor_first_name": string,
     *     "doctor_last_name": string,
     *     "doctor_middle_name": string,
     *     "editable": string,
     *     "meet_result_title": string,
     *     "admission_type_title": string
     * } $originalData
     * @throws VetmanagerApiGatewayException
     */
    public function __construct(ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->id = ApiInt::fromStringOrNull($originalData['medical_card_id'])->positiveInt;
        $this->dateEdit = ApiDateTime::fromOnlyDateString($originalData['date_edit'])->dateTimeOrNull;
        $diagnose = ($originalData['diagnos'] !== '0') ? $originalData['diagnos'] : '';
        $this->diagnose = ApiString::fromStringOrNull($diagnose)->string;
        $this->userId = ApiInt::fromStringOrNull($originalData['doctor_id'])->positiveIntOrNull;
        $this->status = Status::from($originalData['medical_card_status']);
        $this->description = ApiString::fromStringOrNull($originalData['healing_process'])->string;
        $this->recommendation = ApiString::fromStringOrNull($originalData['recomendation'])->string;
        $this->weight = ApiFloat::fromStringOrNull($originalData['weight'])->floatOrNull;
        $this->temperature = ApiFloat::fromStringOrNull($originalData['temperature'])->floatOrNull;
        $this->meetResultId = ApiInt::fromStringOrNull($originalData['meet_result_id'])->positiveIntOrNull;
        $this->admissionTypeId = ApiInt::fromStringOrNull($originalData['admission_type'])->positiveIntOrNull;
        $this->petId = ApiInt::fromStringOrNull($originalData['pet_id'])->positiveInt;
        $this->petAlias = ApiString::fromStringOrNull($originalData['alias'])->string;
        $this->petBirthday = ApiDateTime::fromOnlyDateString($originalData['birthday'])->dateTimeOrNull;
        $this->petSex = $originalData['sex'] ? Sex::from($originalData['sex']) : Sex::Unknown;
        $this->petNote = ApiString::fromStringOrNull($originalData['note'])->string;
        $this->petTypeTitle = ApiString::fromStringOrNull($originalData['pet_type'])->string;
        $this->petBreedTitle = ApiString::fromStringOrNull($originalData['breed'])->string;
        $this->clientId = ApiInt::fromStringOrNull($originalData['client_id'])->positiveInt;
        $this->ownerFullName = new FullName($originalData['first_name'], $originalData['middle_name'], $originalData['last_name']);
        $this->ownerPhone = ApiString::fromStringOrNull($originalData['phone'])->string;
        $this->userLogin = ApiString::fromStringOrNull($originalData['doctor_nickname'])->string;
        $this->userFullName = new FullName($originalData['doctor_first_name'], $originalData['doctor_middle_name'], $originalData['doctor_last_name']);
        $this->isEditable = ApiBool::fromStringOrNull($originalData['editable'])->bool;
        $this->meetResultTitle = ApiString::fromStringOrNull($originalData['meet_result_title'])->string;
        $this->admissionTypeTitle = ApiString::fromStringOrNull($originalData['admission_type_title'])->string;
    }

    /** @return ApiModel::MedicalCardsByClient */
    public static function getApiModel(): ApiModel
    {
        return ApiModel::MedicalCardsByClient;
    }

    /**
     * @param string $additionalGetParameters Строку начинать без "?" или "&". Пример: limit=2&offset=1&sort=[{'property':'title','direction':'ASC'}]&filter=[{'property':'title', 'value':'some value'},
     * @return self[]
     * @throws VetmanagerApiGatewayException Родительское исключение
     * @throws VetmanagerApiGatewayRequestException|VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException
     */
    public static function getByClientId(ApiGateway $apiGateway, int $clientId, string $additionalGetParameters = ''): array
    {
        $additionalGetParametersWithAmpersandOrNothing = $additionalGetParameters ? "&{$additionalGetParameters}" : '';
        $medcardsFromApiResponse = $apiGateway->getContentsWithGetParametersAsString(
            self::getApiModel(),
            "client_id={$clientId}{$additionalGetParametersWithAmpersandOrNothing}"
        );
        return self::fromMultipleDtosArrays($apiGateway, $medcardsFromApiResponse);
    }

    /** @throws VetmanagerApiGatewayException
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'admissionType' => $this->admissionTypeId ? ComboManualItem::getByAdmissionTypeId($this->apiGateway, $this->admissionTypeId) : null,
            'meetResult' => $this->meetResultId ? ComboManualItem::getByAdmissionResultId($this->apiGateway, $this->meetResultId) : null,
            'client' => $this->clientId ? Client::getById($this->apiGateway, $this->clientId) : null,
            'pet' => Pet::getById($this->apiGateway, $this->petId),
            'user' => $this->userId ? User::getById($this->apiGateway, $this->userId) : null,
            default => $this->originalDto->$name
        };
    }
}
