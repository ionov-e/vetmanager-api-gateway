<?php

/** @noinspection PhpUnnecessaryCurlyVarSyntaxInspection */

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use DateTime;
use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\BoolContainer;
use VetmanagerApiGateway\DO\DateTimeContainer;
use VetmanagerApiGateway\DO\FloatContainer;
use VetmanagerApiGateway\DO\FullName;
use VetmanagerApiGateway\DO\IntContainer;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\DTO\Enum\MedicalCard\Status;
use VetmanagerApiGateway\DTO\Enum\Pet\Sex;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

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

        $this->id = IntContainer::fromStringOrNull($originalData['medical_card_id'])->positiveInt;
        $this->dateEdit = DateTimeContainer::fromOnlyDateString($originalData['date_edit'])->dateTimeOrNull;
        $diagnose = ($originalData['diagnos'] !== '0') ? $originalData['diagnos'] : '';
        $this->diagnose = StringContainer::fromStringOrNull($diagnose)->string;
        $this->userId = IntContainer::fromStringOrNull($originalData['doctor_id'])->positiveIntOrNull;
        $this->status = Status::from($originalData['medical_card_status']);
        $this->description = StringContainer::fromStringOrNull($originalData['healing_process'])->string;
        $this->recommendation = StringContainer::fromStringOrNull($originalData['recomendation'])->string;
        $this->weight = FloatContainer::fromStringOrNull($originalData['weight'])->floatOrNull;
        $this->temperature = FloatContainer::fromStringOrNull($originalData['temperature'])->floatOrNull;
        $this->meetResultId = IntContainer::fromStringOrNull($originalData['meet_result_id'])->positiveIntOrNull;
        $this->admissionTypeId = IntContainer::fromStringOrNull($originalData['admission_type'])->positiveIntOrNull;
        $this->petId = IntContainer::fromStringOrNull($originalData['pet_id'])->positiveInt;
        $this->petAlias = StringContainer::fromStringOrNull($originalData['alias'])->string;
        $this->petBirthday = DateTimeContainer::fromOnlyDateString($originalData['birthday'])->dateTimeOrNull;
        $this->petSex = $originalData['sex'] ? Sex::from($originalData['sex']) : Sex::Unknown;
        $this->petNote = StringContainer::fromStringOrNull($originalData['note'])->string;
        $this->petTypeTitle = StringContainer::fromStringOrNull($originalData['pet_type'])->string;
        $this->petBreedTitle = StringContainer::fromStringOrNull($originalData['breed'])->string;
        $this->clientId = IntContainer::fromStringOrNull($originalData['client_id'])->positiveInt;
        $this->ownerFullName = new FullName($originalData['first_name'], $originalData['middle_name'], $originalData['last_name']);
        $this->ownerPhone = StringContainer::fromStringOrNull($originalData['phone'])->string;
        $this->userLogin = StringContainer::fromStringOrNull($originalData['doctor_nickname'])->string;
        $this->userFullName = new FullName($originalData['doctor_first_name'], $originalData['doctor_middle_name'], $originalData['doctor_last_name']);
        $this->isEditable = BoolContainer::fromStringOrNull($originalData['editable'])->bool;
        $this->meetResultTitle = StringContainer::fromStringOrNull($originalData['meet_result_title'])->string;
        $this->admissionTypeTitle = StringContainer::fromStringOrNull($originalData['admission_type_title'])->string;
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
        return self::fromMultipleObjectsContents($apiGateway, $medcardsFromApiResponse);
    }

    /** @throws VetmanagerApiGatewayException
     */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'admissionType' => $this->admissionTypeId ? ActiveRecord\ComboManualItem::getByAdmissionTypeId($this->apiGateway, $this->admissionTypeId) : null,
            'meetResult' => $this->meetResultId ? ActiveRecord\ComboManualItem::getByAdmissionResultId($this->apiGateway, $this->meetResultId) : null,
            'client' => $this->clientId ? ActiveRecord\Client::getById($this->apiGateway, $this->clientId) : null,
            'pet' => ActiveRecord\Pet::getById($this->apiGateway, $this->petId),
            'user' => $this->userId ? ActiveRecord\User::getById($this->apiGateway, $this->userId) : null,
            default => $this->$name,
        };
    }
}
