<?php

/** @noinspection PhpUnnecessaryCurlyVarSyntaxInspection */

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use DateInterval;
use DateTime;
use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Enum\Completeness;
use VetmanagerApiGateway\ActiveRecord\Interface\AllRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllRequestsTrait;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO\MedicalCardAsVaccinationDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

/**
 * @property-read MedicalCardAsVaccinationDto $originalDto
 * @property positive-int $id id из таблицы vaccine_pets
 * @property string $name title из таблицы vaccine_pets
 * @property positive-int $petId
 * @property ?DateTime $date  Дата без времени. Пример: "2012-09-02 00:00:00", а может прийти, если ничего: "0000-00-00". Из таблицы vaccine_pets
 * @property ?DateTime $nextDateTime Может содержать в себе:1) Лишь дату. Тогда в {@see $isTimePresentInNextDateTime} будет false; 2) Дату со временем. Тогда в {@see $isTimePresentInNextDateTime} будет true$ 3) Null; Значение берется из admission_date из таблицы admission ON admission.id = vaccine_pets.next_admission_id.
 * @property bool $isTimePresentInNextDateTime Указывает есть ли время в {@see $nextDateTime}
 * @property positive-int $goodId Default in DB: "0". Но не видел нигде 0 - не предусматриваю
 * @property ?DateTime $petBirthday Дата без времени. Пример: "2012-09-02 00:00:00". Может быть и null
 * @property positive-int $medicalCardId Default: "0". Но не видел нигде 0 - не предусматриваю
 * @property positive-int $doseTypeId Default in DB: "0". Но не видел нигде 0 - не предусматриваю
 * @property float $doseValueDefault: "1.0000000000". Из таблицы vaccine_pets
 * @property positive-int $saleParamId Из таблицы vaccine_pets. Но не видел нигде 0 - не предусматриваю
 * @property ?positive-int $vaccineType
 * @property string $vaccineDescription Default: "". Из таблицы vaccine_pets
 * @property string $vaccineTypeTitle Default: "". Title из таблицы combo_manual_items (строка, где: value = {@see $vaccineType} & combo_manual_id = $comboManualIdOfVaccinationType
 * @property ?positive-int $nextAdmissionId Default in DB: "0". Перевожу в null. Из таблицы vaccine_pets
 * @property-read array{
 *     id: numeric-string,
 *     name: string,
 *     pet_id: numeric-string,
 *     date: string,
 *     date_nexttime: string,
 *     vaccine_id: numeric-string,
 *     birthday: ?string,
 *     birthday_at_time: string,
 *     medcard_id: numeric-string,
 *     doza_type_id: numeric-string,
 *     doza_value: string,
 *     sale_param_id: numeric-string,
 *     vaccine_type: string,
 *     vaccine_description: string,
 *     vaccine_type_title: string,
 *     next_admission_id: numeric-string,
 *     next_visit_time: string,
 *     pet_age_at_time_vaccination: string
 * } $originalDataArray
 * @property-read MedicalCard medicalCard
 * @property-read ?Admission nextAdmission
 * @property-read ?DateInterval petAgeAtVaccinationMoment
 * @property-read ?DateInterval currentPetAgeIfStillAlive
 */
final class MedicalCardAsVaccination extends AbstractActiveRecord implements AllRequestsInterface
{
    use AllRequestsTrait;

    /** @return ApiModel::MedicalCardsVaccinations */
    public static function getApiModel(): ApiModel
    {
        return ApiModel::MedicalCardsVaccinations;
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
        return self::fromMultipleDtosArrays($apiGateway, $petsFromApiResponse);
    }

    public static function getCompletenessFromGetAllOrByQuery(): Completeness
    {
        return Completeness::Full;
    }

    /** @throws VetmanagerApiGatewayException Родительский */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'medicalCard' => MedicalCard::getById($this->activeRecordFactory, $this->medicalCardId),
            'nextAdmission' => $this->nextAdmissionId
                ? Admission::getById($this->activeRecordFactory, $this->nextAdmissionId)
                : null,
            'petAgeAtVaccinationMoment' => $this->getPetAgeAtVaccinationMoment(),
            'currentPetAgeIfStillAlive' => $this->getCurrentPetAgeIfStillAlive(),
            default => $this->originalDto->$name
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
