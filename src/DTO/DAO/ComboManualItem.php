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
     * @param int $id Например: {@see Medcard::admissionType}. По факту это id из таблицы combo_manual_items
     * Первые строки данной таблицы и заполнены admissionType
     * @throws VetmanagerApiGatewayException
     */
    public static function getAdmissionTypeFromApiAndId(ApiGateway $apiGateway, int $id): static
    {
        $return = $apiGateway->getWithQueryBuilder(
            self::getApiModel(),
            (new Builder())
                ->where('combo_manual_id', '2')
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
     * @param int $resultId Например: {@see Medcard::admissionType}. По факту это id из таблицы combo_manual_items
     * @param int $comboManualIdOfAdmissionResult Если не ввести этот параметр - метод подставить самостоятельно с помощью отдельного АПИ-запроса
     * @throws VetmanagerApiGatewayException
     */
    public static function getAdmissionResultFromApiAndResultId(ApiGateway $apiGateway, int $resultId, int $comboManualIdOfAdmissionResult = 0): static
    {
        if ($comboManualIdOfAdmissionResult == 0) {
            $comboManualIdOfAdmissionResult = ComboManualName::getIdFromNameAsEnum($apiGateway, DTO\Enum\ComboManualName\Name::AdmissionResult);
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
}
