<?php

/** @noinspection PhpUnnecessaryCurlyVarSyntaxInspection */

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use DateTime;
use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Enum\Completeness;
use VetmanagerApiGateway\ActiveRecord\Interface\AllRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllRequestsTrait;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\FullName;
use VetmanagerApiGateway\DTO\Enum\MedicalCard\Status;
use VetmanagerApiGateway\DTO\Enum\Pet\Sex;
use VetmanagerApiGateway\DTO\MedicalCardByClientDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

/**
 * @property-read MedicalCardByClientDto $originalDto
 * @property int $id
 * @property ?DateTime $dateEdit
 * @property string $diagnose Либо пустая строка, либо JSON типа: "[ {"id":32,"type":1}, {"id":35,"type":1}, {"id":77,"type":1} ]"
 * @property ?positive-int $userId
 * @property Status $status Default: 'active'
 * @property string $description Может быть просто строка, а может HTML-блок
 * @property string $recommendation Может прийти пустая строка, может просто строка, может HTML
 * @property ?float $weight
 * @property ?float $temperature
 * @property ?positive-int $meetResultId LEFT JOIN combo_manual_items ci2 ON ci2.combo_manual_id = 2 AND ci2.value = m.meet_result_id. 0 переводим в null
 * @property ?positive-int $admissionTypeId {@see MedicalCard::admissionType} Тип приема. LEFT JOIN combo_manual_items ci ON ci.combo_manual_id = {$reasonId} AND ci.value = m.admission_type
 * @property positive-int $petId
 * @property string $petAlias
 * @property ?DateTime $petBirthday Дата без времени
 * @property Sex $petSex
 * @property string $petNote
 * @property string $petTypeTitle
 * @property string $petBreedTitle
 * @property ?positive-int $clientId Не уверен, что вообще можем получить null
 * @property FullName $ownerFullName
 * @property string $ownerPhone
 * @property string $userLogin
 * @property FullName $userFullName
 * @property bool $isEditable Будет False, если в таблице special_studies_medcard_data будет хоть одна запись с таким же medcard_id {@see self::id}
 * @property string $meetResultTitle Пример: "Повторный прием". В таблице combo_manual_items ищет кортеж с combo_manual_id = 2 и value = {@see self::meetResultId}. Из строки возвращается title
 * @property string $admissionTypeTitle Пример: "Вакцинация", "Хирургия", "Первичный" или "Вторичный". В таблице combo_manual_items ищет строку с id = {@see self::admissionType} и возвращает значение из столбца title.
 * @property-read array{
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
 * } $originalData
 * @property-read ?ComboManualItem admissionType
 * @property-read ?ComboManualItem meetResult
 * @property-read ?Client client
 * @property-read Pet pet
 * @property-read ?User user
 */
final class MedicalCardByClient extends AbstractActiveRecord implements AllRequestsInterface
{
    use AllRequestsTrait;

    /** @return ApiModel::MedicalCardsByClient */
    public static function getApiModel(): ApiModel
    {
        return ApiModel::MedicalCardsByClient;
    }

    public static function getCompletenessFromGetAllOrByQuery(): Completeness
    {
        return Completeness::Full;
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
        $medicalCardsFromApiResponse = $apiGateway->getContentsWithGetParametersAsString(
            self::getApiModel(),
            "client_id={$clientId}{$additionalGetParametersWithAmpersandOrNothing}"
        );
        return self::fromMultipleDtosArrays($apiGateway, $medicalCardsFromApiResponse);
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
