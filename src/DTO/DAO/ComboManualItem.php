<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\DAO;

use Otis22\VetmanagerRestApi\Query\Builder;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO;
use VetmanagerApiGateway\DTO\DAO\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\DTO\DAO\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\DTO\DAO\Trait\BasicDAOTrait;
use VetmanagerApiGateway\DTO\Enum\ApiRoute;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class ComboManualItem extends DTO\ComboManualItem implements AllGetRequestsInterface
{
    use BasicDAOTrait, AllGetRequestsTrait;

    public DTO\ComboManualName $comboManualName;

    /** @var array{
     *       "id": string,
     *       "combo_manual_id": string,
     *       "title": string,
     *       "value": string,
     *       "dop_param1": string,
     *       "dop_param2": string,
     *       "dop_param3": string,
     *       "is_active": string,
     *       "comboManualName": array{
     *               "id": string,
     *               "title": string,
     *               "is_readonly": string,
     *               "name": string
     *       }
     *   } $originalData
     */
    protected readonly array $originalData;

    /** @throws VetmanagerApiGatewayException */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->comboManualName = DTO\ComboManualName::fromSingleObjectContents($this->apiGateway, $this->originalData['comboManualName']);
    }

    /**
     * @param int $id Скорее всего тут будет значение из медкарты: {@see MedicalCard::admissionType}
     * @param int $comboManualIdOfAdmissionType Если не ввести этот параметр - метод подставит самостоятельно ID с помощью отдельного АПИ-запроса
     * @throws VetmanagerApiGatewayException
     */
    public static function getByAdmissionTypeId(ApiGateway $apiGateway, int $id, int $comboManualIdOfAdmissionType = 0): static
    {
        if ($comboManualIdOfAdmissionType == 0) {
            $comboManualIdOfAdmissionType = ComboManualName::getIdByNameAsEnum($apiGateway, DTO\Enum\ComboManualName\Name::AdmissionType);
        }

        $return = $apiGateway->getWithQueryBuilder(
            self::getApiModel(),
            (new Builder())
                ->where('combo_manual_id', (string)$comboManualIdOfAdmissionType)
                ->where('id', (string)$id),
            1
        );

        return $return[0];
    }

    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::ComboManualItem;
    }

    /**
     * @param int $resultId Скорее всего тут будет значение из медкарты: {@see MedicalCard::meetResultId}
     * @param int $comboManualIdOfAdmissionResult Если не ввести этот параметр - метод подставит самостоятельно ID с помощью отдельного АПИ-запроса
     * @throws VetmanagerApiGatewayException
     */
    public static function getByAdmissionResultId(ApiGateway $apiGateway, int $resultId, int $comboManualIdOfAdmissionResult = 0): static
    {
        if ($comboManualIdOfAdmissionResult == 0) {
            $comboManualIdOfAdmissionResult = ComboManualName::getIdByNameAsEnum($apiGateway, DTO\Enum\ComboManualName\Name::AdmissionResult);
        }

        $return = $apiGateway->getContentsWithQueryBuilder(
            self::getApiModel(),
            (new Builder())
                ->where('combo_manual_id', (string)$comboManualIdOfAdmissionResult)
                ->where('value', (string)$resultId),
            1
        );

        return $return[0];
    }

    /**
     * @param int $colorId Например: {@see Pet::colorId}. По факту это value из таблицы combo_manual_items
     * @param int $comboManualIdOfPetColors Если не ввести этот параметр - метод подставит самостоятельно ID с помощью отдельного АПИ-запроса
     * @throws VetmanagerApiGatewayException
     */
    public static function getByPetColorId(ApiGateway $apiGateway, int $colorId, int $comboManualIdOfPetColors = 0): static
    {
        if ($comboManualIdOfPetColors == 0) {
            $comboManualIdOfPetColors = ComboManualName::getIdByNameAsEnum($apiGateway, DTO\Enum\ComboManualName\Name::PetColors);
        }

        $return = $apiGateway->getContentsWithQueryBuilder(
            self::getApiModel(),
            (new Builder())
                ->where('combo_manual_id', (string)$comboManualIdOfPetColors)
                ->where('value', (string)$colorId),
            1
        );

        return $return[0];
    }

    /**
     * @param int $vaccineTypeId vaccine_type из таблицы vaccine_pets
     * @param int $comboManualIdOfVaccineTypes Если не ввести этот параметр - метод подставит самостоятельно ID с помощью отдельного АПИ-запроса
     * @throws VetmanagerApiGatewayException
     */
    public static function getByVaccineTypeId(ApiGateway $apiGateway, int $vaccineTypeId, int $comboManualIdOfVaccineTypes = 0): static
    {
        if ($comboManualIdOfVaccineTypes == 0) {
            $comboManualIdOfVaccineTypes = ComboManualName::getIdByNameAsEnum($apiGateway, DTO\Enum\ComboManualName\Name::VaccinationType);
        }

        $return = $apiGateway->getContentsWithQueryBuilder(
            self::getApiModel(),
            (new Builder())
                ->where('combo_manual_id', (string)$comboManualIdOfVaccineTypes)
                ->where('value', (string)$vaccineTypeId),
            1
        );

        return $return[0];
    }
}
