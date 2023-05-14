<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use Otis22\VetmanagerRestApi\Query\Builder;
use VetmanagerApiGateway\ActiveRecord\Enum\ApiRoute;
use VetmanagerApiGateway\ActiveRecord\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllGetRequestsTrait;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO;
use VetmanagerApiGateway\DTO\Enum\ComboManualName\Name;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

final class ComboManualName extends AbstractActiveRecord implements AllGetRequestsInterface
{

    use AllGetRequestsTrait;

    /** @var DTO\ComboManualItemDto[] $comboManualItems */
    public array $comboManualItems;

    /** @param array{
     *       "id": string,
     *       "title": string,
     *       "is_readonly": string,
     *       "name": string,
     *       "comboManualItems": array<int, array{
     *                                          "id": string,
     *                                          "combo_manual_id": string,
     *                                          "title": string,
     *                                          "value": string,
     *                                          "dop_param1": string,
     *                                          "dop_param2": string,
     *                                          "dop_param3": string,
     *                                          "is_active": string
     *                                          }
     *                                  >
     *   } $originalData
     * @throws VetmanagerApiGatewayException
     */
    public function __construct(ApiGateway $apiGateway, array $originalData)
    {
        parent::__construct($apiGateway, $originalData);

        $this->comboManualItems = ComboManualItem::fromMultipleObjectsContents(
            $this->apiGateway,
            $originalData['comboManualItems']
        ); #TODO this was dto
    }

    /** @return ApiRoute::ComboManualName */
    public static function getApiModel(): ApiRoute
    {
        return ApiRoute::ComboManualName;
    }

    /**
     * @throws VetmanagerApiGatewayException - родительское исключение
     * @throws VetmanagerApiGatewayRequestException|VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException
     */
    public static function getByName(ApiGateway $apiGateway, string $comboManualName): self
    {
        $comboManualNames = self::getByQueryBuilder($apiGateway, (new Builder())->where("name", $comboManualName), 1);
        return $comboManualNames[0];
    }

    /**
     * @param string $comboManualName Вместо строки можно пользоваться методом, принимающий Enum {@see getIdByNameAsEnum}
     * @throws VetmanagerApiGatewayException - родительское исключение
     * @throws VetmanagerApiGatewayRequestException|VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException
     */
    public static function getIdByNameAsString(ApiGateway $apiGateway, string $comboManualName): int
    {
        return self::getByName($apiGateway, $comboManualName)->id;
    }

    /**
     * @param Name $comboManualName Не нравится пользоваться Enum или не хватает значения - другой метод {@see getIdByNameAsString}
     * @throws VetmanagerApiGatewayException - родительское исключение
     * @throws VetmanagerApiGatewayRequestException|VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException
     */
    public static function getIdByNameAsEnum(ApiGateway $apiGateway, Name $comboManualName): int
    {
        return self::getIdByNameAsString($apiGateway, $comboManualName->value);
    }

    /** @throws VetmanagerApiGatewayException */
    public function __get(string $name): mixed
    {
        return match ($name) {
            default => $this->$name,
        };
    }
}
