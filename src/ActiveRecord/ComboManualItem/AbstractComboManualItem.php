<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\ComboManualItem;

use Otis22\VetmanagerRestApi\Query\Builder;
use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecord\ComboManualName\ComboManualNameOnly;
use VetmanagerApiGateway\ActiveRecord\MedicalCard\AbstractMedicalCard;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO\ComboManualItem\ComboManualItemOnlyDto;
use VetmanagerApiGateway\DTO\ComboManualName\NameEnum;
use VetmanagerApiGateway\DTO\Pet\PetOnlyDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/**
 * @property-read ComboManualItemOnlyDto $originalDto
 * @property positive-int $id
 * @property positive-int $comboManualId
 * @property string $title Default: ''
 * @property string $value Default: ''
 * @property string $dopParam1 Default: ''
 * @property string $dopParam2 Default: ''
 * @property string $dopParam3 Default: ''
 * @property bool $isActive Default: true
 * @property-read array{
 *       id: string,
 *       combo_manual_id: string,
 *       title: string,
 *       value: string,
 *       dop_param1: string,
 *       dop_param2: string,
 *       dop_param3: string,
 *       is_active: string,
 *       comboManualName: array{
 *               id: string,
 *               title: string,
 *               is_readonly: string,
 *               name: string
 *       }
 *  } $originalDataArray comboManualName при GetAll тоже
 * @property-read ComboManualNameOnly $comboManualName
 */
abstract class AbstractComboManualItem extends AbstractActiveRecord
{

//    public static function getCompletenessFromGetAllOrByQuery(): Completeness
//    {
//        return Completeness::Full;
//    }

    public static function getRouteKey(): string
    {
        return 'comboManualItem';
    }

    /**
     * @param int $typeId Например, значение из медкарты: {@see AbstractMedicalCard::admissionTypeId}
     * @param int $comboManualIdOfAdmissionType Если не ввести этот параметр - метод подставит самостоятельно ID с помощью отдельного АПИ-запроса
     * @throws VetmanagerApiGatewayException
     */
    public static function getByAdmissionTypeId(ApiGateway $apiGateway, int $typeId, int $comboManualIdOfAdmissionType = 0): self
    {
        if ($comboManualIdOfAdmissionType) {
            return self::getOneByValueAndComboManualId($apiGateway, (string)$typeId, $comboManualIdOfAdmissionType);
        }

        return self::getOneByValueAndComboManualName($apiGateway, (string)$typeId, NameEnum::AdmissionType);
    }

    /**
     * @param int $resultId Скорее всего тут будет значение из медкарты: {@see AbstractMedicalCard::meetResultId}
     * @param int $comboManualIdOfAdmissionResult Если не ввести этот параметр - метод подставит самостоятельно ID с помощью отдельного АПИ-запроса
     * @throws VetmanagerApiGatewayException
     */
    public static function getByAdmissionResultId(ApiGateway $apiGateway, int $resultId, int $comboManualIdOfAdmissionResult = 0): self
    {
        if ($comboManualIdOfAdmissionResult) {
            return self::getOneByValueAndComboManualId($apiGateway, (string)$resultId, $comboManualIdOfAdmissionResult);
        }

        return self::getOneByValueAndComboManualName($apiGateway, (string)$resultId, NameEnum::AdmissionResult);
    }

    /**
     * @param int $colorId Например: {@see PetOnlyDto::colorId}. По факту это value из таблицы combo_manual_items
     * @param int $comboManualIdOfPetColors Если не ввести этот параметр - метод подставит самостоятельно ID с помощью отдельного АПИ-запроса
     * @throws VetmanagerApiGatewayException
     */
    public static function getByPetColorId(ApiGateway $apiGateway, int $colorId, int $comboManualIdOfPetColors = 0): self
    {
        if ($comboManualIdOfPetColors) {
            return self::getOneByValueAndComboManualId($apiGateway, (string)$colorId, $comboManualIdOfPetColors);
        }

        return self::getOneByValueAndComboManualName($apiGateway, (string)$colorId, NameEnum::PetColors);
    }

    /**
     * @param int $vaccineTypeId vaccine_type из таблицы vaccine_pets
     * @param int $comboManualIdOfVaccineTypes Если не ввести этот параметр - метод подставит самостоятельно ID с помощью отдельного АПИ-запроса
     * @throws VetmanagerApiGatewayException
     */
    public static function getByVaccineTypeId(ApiGateway $apiGateway, int $vaccineTypeId, int $comboManualIdOfVaccineTypes = 0): self
    {
        if ($comboManualIdOfVaccineTypes) {
            return self::getOneByValueAndComboManualId($apiGateway, (string)$vaccineTypeId, $comboManualIdOfVaccineTypes);
        }

        return self::getOneByValueAndComboManualName($apiGateway, (string)$vaccineTypeId, NameEnum::VaccinationType);
    }

    /** @throws VetmanagerApiGatewayException Родительское исключение */
    public static function getOneByValueAndComboManualName(ApiGateway $apiGateway, string $comboManualValue, NameEnum $comboManualName): self
    {
        $comboManualId = self::getComboManualIdFromComboManualName($apiGateway, $comboManualName);

        return self::getOneByValueAndComboManualId($apiGateway, $comboManualValue, $comboManualId);
    }

    /** @throws VetmanagerApiGatewayException Родительское исключение */
    private static function getComboManualIdFromComboManualName(ApiGateway $apiGateway, NameEnum $comboManualName): int
    {
        return ComboManualNameOnly::getIdByNameAsEnum($apiGateway, $comboManualName);
    }

    /** @throws VetmanagerApiGatewayException */
    private static function getOneByValueAndComboManualId(ApiGateway $apiGateway, string $comboManualValue, int $comboManualId): self
    {
        $comboManualItems = self::getByQueryBuilder(
            $apiGateway,
            (new Builder())
                ->where('combo_manual_id', (string)$comboManualId)
                ->where('value', $comboManualValue),
            1
        );

        return $comboManualItems[0];
    }

    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            'comboManualName' => ($this->completenessLevel == Completeness::Full)
                ? ComboManualNameOnly::fromSingleDtoArrayUsingBasicDto($this->activeRecordFactory, $this->originalDataArray['comboManualName'])
                : ComboManualNameOnly::getById($this->activeRecordFactory, $this->comboManualId),
            default => $this->originalDto->$name
        };
    }
}
