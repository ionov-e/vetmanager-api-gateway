<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\DAO\Trait;

use Otis22\VetmanagerRestApi\Query\Builder;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO\DAO\Interface\AllConstructorsInterface;
use VetmanagerApiGateway\DTO\Enum\ApiRoute;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

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
     * @return static[]
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public static function fromRequestGetAll(ApiGateway $apiGateway, int $maxLimitOfReturnedModels = 100): array
    {
        return self::fromRequestGetByQueryBuilder($apiGateway, (new Builder())->top($maxLimitOfReturnedModels), $maxLimitOfReturnedModels);
    }

    /** @inheritDoc
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public static function fromRequestGetById(ApiGateway $apiGateway, int $modelId): static
    {
        return new self(
            $apiGateway,
            $apiGateway->getWithId(static::getApiModel(), $modelId)
        );
    }

    /** @inheritDoc
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public static function fromRequestGetByParametersAsString(ApiGateway $apiGateway, string $getParameters): array
    {
        return self::fromMultipleDecodedJsons(
            $apiGateway,
            $apiGateway->getWithGetParametersAsString(static::getApiModel(), $getParameters)
        );
    }

    /** @inheritDoc
     * @return static[]
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public static function fromRequestGetByQueryBuilder(ApiGateway $apiGateway, PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        $response = $apiGateway->getWithPagedQuery(static::getApiModel(), $pagedQuery, $maxLimitOfReturnedModels);
        return static::fromMultipleDecodedJsons($apiGateway, $response);
    }

    /** @inheritDoc
     * @return static[]
     * @throws VetmanagerApiGatewayResponseEmptyException
     */
    public static function fromMultipleDecodedJsons(ApiGateway $apiGateway, array $arrayOfObjectsAsDecodedJsons): array
    {
        return static::fromMultipleInnerContentsOfDecodedJsons(
            $apiGateway,
            $arrayOfObjectsAsDecodedJsons[static::getApiModel()->getApiModelResponseKey()]
        );
    }

    /** @inheritDoc
     * @return static[]
     * @throws VetmanagerApiGatewayResponseEmptyException
     */
    public static function fromMultipleInnerContentsOfDecodedJsons(ApiGateway $apiGateway, array $arrayOfDtosContentsAsDecodedJsons): array
    {
        return array_map(
            fn (array $modelAsDecodedJson): static => static::fromDecodedJson($apiGateway, $modelAsDecodedJson),
            $arrayOfDtosContentsAsDecodedJsons
        );
    }
}
