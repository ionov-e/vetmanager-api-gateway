<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use Otis22\VetmanagerRestApi\Query\Builder;
use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Enum\Completeness;
use VetmanagerApiGateway\ActiveRecord\Interface\AllRequestsInterface;
use VetmanagerApiGateway\ActiveRecord\Trait\AllRequestsTrait;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO\ComboManualNameDto;
use VetmanagerApiGateway\DTO\Enum\ComboManualName\Name;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

/**
 * @property-read ComboManualNameDto $originalDto
 * @property positive-int id
 * @property non-empty-string title
 * @property bool isReadonly
 * @property non-empty-string name
 * @property-read array{
 *       id: string,
 *       title: string,
 *       is_readonly: string,
 *       name: string,
 *       comboManualItems: list<array{
 *                                    id: string,
 *                                    combo_manual_id: string,
 *                                    title: string,
 *                                    value: string,
 *                                    dop_param1: string,
 *                                    dop_param2: string,
 *                                    dop_param3: string,
 *                                    is_active: string
 *                                   }
 *                             >
 *   } $originalDataArray 'comboManualItems' массив только при GetById
 * @property-read comboManualItem[] comboManualItems
 */
final class ComboManualName extends AbstractActiveRecord implements AllRequestsInterface
{
    use AllRequestsTrait;

    /** @return ApiModel::ComboManualName */
    public static function getApiModel(): ApiModel
    {
        return ApiModel::ComboManualName;
    }

    public static function getCompletenessFromGetAllOrByQuery(): Completeness
    {
        return Completeness::OnlyBasicDto;
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
        switch ($name) {
            case 'comboManualItems':
                $this->fillCurrentObjectWithGetByIdDataIfSourceIsFromBasicDto();
                return ComboManualItem::fromMultipleDtosArrays(
                    $this->apiGateway,
                    $this->originalDataArray['comboManualItems']
                );
            default:
                return $this->originalDto->$name;
        }
    }
}
