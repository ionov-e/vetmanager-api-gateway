<?php
declare(strict_types=1);

namespace VetmanagerApiGateway\DAO;

use Otis22\VetmanagerRestApi\Query\Builder;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DAO\Interface\AllConstructorsInterface;
use VetmanagerApiGateway\DAO\Trait\AllConstructorsTrait;
use VetmanagerApiGateway\DTO;
use VetmanagerApiGateway\Enum\ApiRoute;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class ComboManualItem extends DTO\ComboManualItem implements AllConstructorsInterface
{
    use AllConstructorsTrait;

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
    readonly protected array $originalData;

    /** @throws VetmanagerApiGatewayException */
    public function __construct(protected ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->comboManualName = DTO\ComboManualName::fromDecodedJson($this->apiGateway, $this->originalData['comboManualName']);
    }

    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::ComboManualItem;
    }

    /**
     * @param int $id Например: {@see Medcard::admissionType}. По факту это id из таблицы combo_manual_items
     * Первые строки данной таблицы и заполнены admissionType
     * @throws VetmanagerApiGatewayException
     */
    public static function getAdmissionTypeFromApiAndId(ApiGateway $apiGateway, int $id): static
    {
        $return = $apiGateway->getContentsWithPagedQuery(
            self::getApiModel(),
            (new Builder())
                ->where('combo_manual_id', '2')
                ->where('id', (string)$id)
                ->top(1)
        );

        return $return[0];
    }

    /**
     * @param int $resultId Например: {@see Medcard::admissionType}. По факту это id из таблицы combo_manual_items
     * Первые строки данной таблицы и заполнены admissionType
     * @throws VetmanagerApiGatewayException
     */
    public static function getAdmissionResultFromApiAndResultId(ApiGateway $apiGateway, int $resultId): static
    {
        $return = $apiGateway->getContentsWithPagedQuery(
            self::getApiModel(),
            (new Builder())
                ->where('combo_manual_id', '2')
                ->where('value', (string)$resultId)
                ->top(1)
        );

        return $return[0];

        #TODO Check if code above works

//        return new static (
//            $apiGateway,
//            $apiGateway->getResultUsingPagedQuery(
//                self::getApiModel(),
//                (new Builder())
//                    ->where('combo_manual_id', '2')
//                    ->where('id', (string)$value)
//                    ->top(1)
//            )
//        );
    }

}
