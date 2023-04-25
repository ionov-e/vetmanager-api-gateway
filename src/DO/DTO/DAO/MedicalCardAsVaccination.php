<?php

/** @noinspection PhpUnnecessaryCurlyVarSyntaxInspection */

declare(strict_types=1);

namespace VetmanagerApiGateway\DO\DTO\DAO;

use DateInterval;
use DateTime;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DO\DateTimeContainer;
use VetmanagerApiGateway\DO\DTO\AbstractDTO;
use VetmanagerApiGateway\DO\DTO\DAO;
use VetmanagerApiGateway\DO\DTO\DAO\Trait\BasicDAOTrait;
use VetmanagerApiGateway\DO\Enum\ApiRoute;
use VetmanagerApiGateway\DO\FloatContainer;
use VetmanagerApiGateway\DO\IntContainer;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

/**
 * @property-read DAO\MedicalCard medicalCard
 * @property-read ?DAO\AdmissionFromGetById nextAdmission
 * @property-read ?DateInterval petAgeAtVaccinationMoment
 * @property-read ?DateInterval currentPetAgeIfStillAlive
 */
final class MedicalCardAsVaccination extends AbstractDTO
{
    use BasicDAOTrait;

    /** @var positive-int id из таблицы vaccine_pets */
    public int $vaccineId;
    /** title из таблицы vaccine_pets */
    public string $name;
    /** @var positive-int */
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
    /** @var positive-int Default: "0". Но не видел нигде 0 - не предусматриваю */
    public int $goodId;
    /** Дата без времени. Пример: "2012-09-02 00:00:00". Может быть и null */
    public ?DateTime $petBirthday;
    /** @var positive-int Default: "0". Но не видел нигде 0 - не предусматриваю */
    public int $medcardId;
    /** @var positive-int Default: "0". Но не видел нигде 0 - не предусматриваю */
    public int $doseTypeId;
    /** Default: "1.0000000000". Из таблицы vaccine_pets*/
    public float $doseValue;
    /** @var positive-int Из таблицы vaccine_pets. Но не видел нигде 0 - не предусматриваю */
    public int $saleParamId;
    /** @var positive-int|null Default: "0" - перевожу в null */
    public ?int $vaccineType;
    /** Default: "". Из таблицы vaccine_pets */
    public string $vaccineDescription;
    /** Default: "". Title из таблицы combo_manual_items (строка, где: value = {@see $vaccineType} & combo_manual_id = $comboManualIdOfVaccinationType*/
    public string $vaccineTypeTitle;
    /** @var positive-int|null Default: "0". Перевожу в null. Из таблицы vaccine_pets */
    public ?int $nextAdmissionId;

    /** @param array{
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
     * @throws VetmanagerApiGatewayException
     */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->vaccineId = IntContainer::fromStringOrNull($originalData['id'])->positiveInt;
        $this->name = StringContainer::fromStringOrNull($originalData['name'])->string;
        $this->petId = IntContainer::fromStringOrNull($originalData['pet_id'])->positiveInt;
        $this->date = DateTimeContainer::fromFullDateTimeString($originalData['date'])->dateTimeOrNull;
        $dateTimeServiceForNextDate = DateTimeContainer::fromOnlyDateString($originalData['date_nexttime']);
        $this->nextDateTime = $dateTimeServiceForNextDate->dateTimeOrNull;
        $this->isTimePresentInNextDateTime = $dateTimeServiceForNextDate->isTimePresent();
        $this->goodId = IntContainer::fromStringOrNull($originalData['vaccine_id'])->positiveInt;
        $this->medcardId = IntContainer::fromStringOrNull($originalData['medcard_id'])->positiveInt;
        $this->doseTypeId = IntContainer::fromStringOrNull($originalData['doza_type_id'])->positiveInt;
        $this->doseValue = FloatContainer::fromStringOrNull($originalData['doza_value'])->float;
        $this->saleParamId = IntContainer::fromStringOrNull($originalData['sale_param_id'])->positiveInt;
        $this->vaccineType = IntContainer::fromStringOrNull($originalData['vaccine_type'])->positiveIntOrNull;
        $this->vaccineDescription = StringContainer::fromStringOrNull($originalData['vaccine_description'])->string;
        $this->vaccineTypeTitle = StringContainer::fromStringOrNull($originalData['vaccine_type_title'])->string;
        $this->nextAdmissionId = IntContainer::fromStringOrNull($originalData['next_admission_id'])->positiveIntOrNull;
        $this->petBirthday = DateTimeContainer::fromOnlyDateString($originalData['birthday'])->dateTimeOrNull;
        // "birthday_at_time" игнорируем. Бред присылается
        // "pet_age_at_time_vaccination" - Тоже игнорируем, ерунда
    }

    /** @return ApiRoute::MedicalCardsVaccinations */
    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::MedicalCardsVaccinations;
    }

    /**
     * @param string $additionalGetParameters Строку начинать без "?" или "&". Пример: limit=2&offset=1&sort=[{'property':'title','direction':'ASC'}]&filter=[{'property':'title', 'value':'some value'},
     * @return self[]
     * @throws VetmanagerApiGatewayException Родительское исключение
     * @throws VetmanagerApiGatewayRequestException|VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException
     */
    public static function getByPetId(ApiGateway $apiGateway, int $petId, string $additionalGetParameters = ''): array
    {
        $additionalGetParametersWithAmpersandOrNothing = $additionalGetParameters ? "&{$additionalGetParameters}" : '';
        $petsFromApiResponse = $apiGateway->getContentsWithGetParametersAsString(
            self::getApiModel(),
            "pet_id={$petId}{$additionalGetParametersWithAmpersandOrNothing}"
        );
        return self::fromMultipleObjectsContents($apiGateway, $petsFromApiResponse);
    }

    /** @throws VetmanagerApiGatewayException Родительский */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'medicalCard' => DAO\MedicalCard::getById($this->apiGateway, $this->medcardId),
            'nextAdmission' => $this->nextAdmissionId
                ? DAO\AdmissionFromGetById::getById($this->apiGateway, $this->nextAdmissionId)
                : null,
            'petAgeAtVaccinationMoment' => $this->getPetAgeAtVaccinationMoment(),
            'currentPetAgeIfStillAlive' => $this->getCurrentPetAgeIfStillAlive(),
            default => $this->$name,
        };
    }

    private function getPetAgeAtVaccinationMoment(): ?DateInterval
    {
        if (is_null($this->date) || is_null($this->petBirthday)) {
            return null;
        }

        return date_diff($this->date, $this->petBirthday);
    }

    private function getCurrentPetAgeIfStillAlive(): ?DateInterval
    {
        return $this->petBirthday ? date_diff(new DateTime(), $this->petBirthday) : null;
    }
}
