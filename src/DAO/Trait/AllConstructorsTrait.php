<?php

namespace VetmanagerApiGateway\DAO\Trait;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DAO\Interface\AllConstructorsInterface;
use VetmanagerApiGateway\Enum\ApiRoute;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;
use Otis22\VetmanagerRestApi\Query\PagedQuery;

/**
 * Реализация интерфейса {@see AllConstructorsInterface}. Используется только в дочерних классах DTO {@see AbstractDTO} этой библиотеки.
 * Не все DTO имеют прямой АПИ доступ. Методы перечисленные в этом трейте могут быть отнесены только к DTO с прямым доступом
 *
 * @property-read ApiGateway $apiGateway {@see AbstractDTO::$apiGateway}
 * @property array $originalData {@see AbstractDTO::$originalData}
 * @method static ApiRoute getApiModel(ApiGateway $apiGateway, array $array)
 * @method static self fromDecodedJson(ApiGateway $apiGateway, array $array)
 * @method static self fromJson(ApiGateway $apiGateway, string $json)
 *
 * PhpDoc пока не поддерживает ссылки в описаниях методов, поэтому приведены ниже:
 * {@see AllConstructorsInterface::getApiModel()} {@see AbstractDTO::fromDecodedJson()} {@see AbstractDTO::fromJson()}
 */
trait AllConstructorsTrait
{
    /** @inheritDoc
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public static function fromRequestById(ApiGateway $apiGateway, int $modelId): static
    {
        return new self (
            $apiGateway,
            $apiGateway->getWithId(static::getApiModel(), $modelId)
        );
    }

    /** @inheritDoc
     * @return static[]
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public static function fromRequestByQueryBuilder(ApiGateway $apiGateway, PagedQuery $pagedQuery): array
    {
        $response = $apiGateway->getWithPagedQuery(static::getApiModel(), $pagedQuery);

        return static::fromMultipleDecodedJsons($apiGateway, $response);
    }

    /** @inheritDoc
     * @return static[]
     * @throws VetmanagerApiGatewayResponseEmptyException
     */
    public static function fromMultipleDecodedJsons(ApiGateway $apiGateway, array $arrayOfObjectsAsDecodedJsons): array
    {
        return static::fromInnerContentsOfDecodedJsons(
            $apiGateway,
            $arrayOfObjectsAsDecodedJsons[static::getApiModel()->getApiModelResponseKey()]
        );
    }

    /** @inheritDoc
     * @return static[]
     * @throws VetmanagerApiGatewayResponseEmptyException
     */
    public static function fromInnerContentsOfDecodedJsons(ApiGateway $apiGateway, array $arrayOfDtosContentsAsDecodedJsons): array
    {
        return array_map(
            fn(array $modelAsDecodedJson): static => static::fromDecodedJson($apiGateway, $modelAsDecodedJson),
            $arrayOfDtosContentsAsDecodedJsons
        );
    }
}
