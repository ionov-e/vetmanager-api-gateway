<?php /** @noinspection PhpUnnecessaryCurlyVarSyntaxInspection */

declare(strict_types=1);

namespace VetmanagerApiGateway\DO\DTO\DAO;

use DateInterval;
use DateTime;
use Exception;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\DateTimeContainer;
use VetmanagerApiGateway\DO\DTO\AbstractDTO;
use VetmanagerApiGateway\DO\DTO\DAO\Trait\BasicDAOTrait;
use VetmanagerApiGateway\DO\Enum\ApiRoute;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

/**
 * @property-read MedicalCard medicalCard
 * @property-read ?AdmissionFromGetById nextAdmission
 * @property-read ?DateInterval petAgeAtVaccinationMoment
 * @property-read ?DateInterval currentPetAgeIfStillAlive
 */
class MedicalCardAsVaccination extends AbstractDTO
{
    use BasicDAOTrait;

    /** id из таблицы vaccine_pets */
    public int $vaccineId;
    /** title из таблицы vaccine_pets */
    public string $name;
    public int $petId;
    /** Дата без времени. Пример: "2012-09-02 00:00:00", а может прийти, если ничего: "0000-00-00". Из таблицы vaccine_pets*/
    public ?DateTime $date;
    /** Может содержать в себе:
     * 1) Лишь дату. Тогда в {@see $isTimePresentInNextDateTime} будет false
     * 2) Дату со временем. Тогда в {@see $isTimePresentInNextDateTime} будет true
     * 3) Null
     * Значение берется из admission_date из таблицы admission ON admission.id = vaccine_pets.next_admission_id. */
    public ?DateTime $nextDateTime;
    /** Указывает есть ли время в {@see $nextDateTime} */
    public bool $isTimePresentInNextDateTime;
    public int $goodId;
    /** Дата без времени. Пример: "2012-09-02 00:00:00". Может быть и null */
    public ?DateTime $petBirthday;
    public int $medcardId;
    /** Default: "0" */
    public int $doseTypeId;
    /** Default: "1.0000000000". Из таблицы vaccine_pets*/
    public float $doseValue;
    /** Из таблицы vaccine_pets */
    public int $saleParamId;
    /** Default: "0". Перевожу в null. Из таблицы vaccine_pets */
    public int $vaccineType;
    /** Default: "". Из таблицы vaccine_pets */
    public string $vaccineDescription;
    /** Default: "". Title из таблицы combo_manual_items (строка, где: value = {@see $vaccineType} & combo_manual_id = $comboManualIdOfVaccinationType*/
    public string $vaccineTypeTitle;
    /** Default: "0". Перевожу в null. Из таблицы vaccine_pets */
    public int $nextAdmissionId;
    /** @var array{
     *     "id": string,
     *     "name": string,
     *     "pet_id": string,
     *     "date": string,
     *     "date_nexttime": string,
     *     "vaccine_id": string,
     *     "birthday": ?string,
     *     "birthday_at_time": string,
     *     "medcard_id": string,
     *     "doza_type_id": string,
     *     "doza_value": string,
     *     "sale_param_id": string,
     *     "vaccine_type": string,
     *     "vaccine_description": string,
     *     "vaccine_type_title": string,
     *     "next_admission_id": string,
     *     "next_visit_time": string,
     *     "pet_age_at_time_vaccination": string
     * } $originalData
     */
    protected readonly array $originalData;

    /** @throws VetmanagerApiGatewayException */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->vaccineId = (int)$this->originalData['id'];
        $this->name = (string)$this->originalData['name'];
        $this->petId = (int)$this->originalData['pet_id'];
        $this->date = (DateTimeContainer::fromFullDateTimeString($this->originalData['date']))->dateTimeNullable;

        $dateTimeService = (DateTimeContainer::fromFullDateTimeString($this->originalData['create_date']));
        $this->nextDateTime = $dateTimeService->dateTimeNullable;
        $this->isTimePresentInNextDateTime = $dateTimeService->isTimePresent();

        $this->goodId = (int)$this->originalData['vaccine_id'];
        $this->medcardId = (int)$this->originalData['medcard_id'];
        $this->doseTypeId = (int)$this->originalData['doza_type_id'];
        $this->doseValue = (float)$this->originalData['doza_value'];
        $this->saleParamId = (int)$this->originalData['sale_param_id'];
        $this->vaccineType = (int)$this->originalData['vaccine_type'];
        $this->vaccineDescription = (string)$this->originalData['vaccine_description'];
        $this->vaccineTypeTitle = (string)$this->originalData['vaccine_type_title'];
        $this->nextAdmissionId = (int)$this->originalData['next_admission_id'];
        $this->petBirthday = (DateTimeContainer::fromOnlyDateString($this->originalData['birthday']))->dateTimeNullable;
        // "birthday_at_time" игнорируем. Бред присылается
        // "pet_age_at_time_vaccination" - Тоже игнорируем, ерунда
    }

    /**
     * @param ?string $date Приходят строки типа: "0000-00-00", "2023-06-06"
     * @param ?string $time Приходят строки типа: "12:20", ""
     * @return array{?DateTime, bool}
     * @throws Exception
     */
    private function getDateTimeWithTimeIndicationForNextAdmission(?string $date, ?string $time): array
    {
        if (!$date || $date == "0000-00-00") {
            return [null, false];
        }

        if (!$time || $time == "") {
            return [new DateTime($date), false];
        }

        return [new DateTime("{$date} {$time}"), true];
    }

    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::MedicalCardsVaccinations;
    }

    /**
     * @param string $additionalGetParameters Строку начинать без "?" или "&". Пример: limit=2&offset=1&sort=[{'property':'title','direction':'ASC'}]&filter=[{'property':'title', 'value':'some value'},
     * @return self []
     * @throws VetmanagerApiGatewayException Родительское исключение
     * @throws VetmanagerApiGatewayRequestException|VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException
     */
    public static function getByPetId(ApiGateway $apiGateway, int $petId, string $additionalGetParameters = ''): array
    {
        $additionalGetParametersWithAmpersandOrNothing = $additionalGetParameters ? "&{$additionalGetParameters}" : '';
        return $apiGateway->getWithGetParametersAsString(
            self::getApiModel(),
            "pet_id={$petId}{$additionalGetParametersWithAmpersandOrNothing}"
        );
    }

    /** @throws VetmanagerApiGatewayException Родительский */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'medicalCard' => MedicalCard::getById($this->apiGateway, $this->medcardId),
            'nextAdmission' => $this->nextAdmissionId
                ? AdmissionFromGetById::getById($this->apiGateway, $this->nextAdmissionId)
                : null,
            'petAgeAtVaccinationMoment' => $this->getPetAgeAtVaccinationMoment(),
            'currentPetAgeIfStillAlive' => $this->getCurrentPetAgeIfStillAlive(),
            default => $this->$name,
        };
    }

    private function getPetAgeAtVaccinationMoment(): ?DateInterval
    {
        if (!is_null($this->date) || !is_null($this->petBirthday)) {
            return null;
        }

        return date_diff($this->date, $this->petBirthday);
    }

    private function getCurrentPetAgeIfStillAlive(): ?DateInterval
    {
        return $this->petBirthday ? date_diff(new DateTime(), $this->petBirthday) : null;
    }
}
