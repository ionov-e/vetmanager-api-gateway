<?php

/** @noinspection PhpFullyQualifiedNameUsageInspection */
declare(strict_types=1);

namespace VetmanagerApiGateway;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Otis22\VetmanagerRestApi\Headers\Auth\ApiKey;
use Otis22\VetmanagerRestApi\Headers\Auth\ByApiKey;
use Otis22\VetmanagerRestApi\Headers\Auth\ByServiceApiKey;
use Otis22\VetmanagerRestApi\Headers\Auth\ServiceName;
use Otis22\VetmanagerRestApi\Headers\WithAuth;
use Otis22\VetmanagerRestApi\Headers\WithAuthAndParams;
use Otis22\VetmanagerRestApi\Model;
use Otis22\VetmanagerRestApi\Query\Builder;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use Otis22\VetmanagerRestApi\URI\OnlyModel;
use Otis22\VetmanagerRestApi\URI\RestApiPrefix;
use Otis22\VetmanagerRestApi\URI\WithId;
use Psr\Http\Message\ResponseInterface;
use VetmanagerApiGateway\DO\Enum\ApiRoute;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;
use function Otis22\VetmanagerUrl\url as vetmanager_url;
use function Otis22\VetmanagerUrl\url_test_env as vetmanager_url_test_env;

final class ApiGateway
{
    public function __construct(
        public readonly string               $subDomain,
        public readonly string               $apiUrl,
        protected Client                     $guzzleClient,
        protected WithAuthAndParams|WithAuth $allHeaders
    ) {
    }

    /** @throws VetmanagerApiGatewayRequestException */
    public static function fromDomainAndServiceNameAndApiKey(
        string $subDomain,
        string $serviceName,
        string $apiKey,
        bool   $isProduction,
        string $timezone = '+03:00'
    ): self {
        try {
            $baseApiUrl = $isProduction
                ? vetmanager_url($subDomain)->asString()
                : vetmanager_url_test_env($subDomain)->asString();
        } catch (\Exception $e) {
            throw new VetmanagerApiGatewayRequestException($e->getMessage());
        }

        $guzzleClient = new Client(
            [
                'base_uri' => $baseApiUrl,
                'http_errors' => false,
                'verify' => false,
            ]
        );

        $allHeaders = new WithAuthAndParams(
            new ByServiceApiKey(
                new ServiceName($serviceName),
                new ApiKey($apiKey)
            ),
            [
                'X-REST-TIME-ZONE' => $timezone,
            ]
        );

        return new self($subDomain, $baseApiUrl, $guzzleClient, $allHeaders);
    }

    /** @throws VetmanagerApiGatewayRequestException */
    public static function fromDomainAndApiKey(
        string $subDomain,
        string $apiKey,
        bool   $isProduction,
        string $timezone = '+03:00'
    ): self {
        try {
            $baseApiUrl = ($isProduction)
                ? vetmanager_url($domainName)->asString()
                : vetmanager_url_test_env($domainName)->asString();
        } catch (\Exception $e) {
            throw new VetmanagerApiGatewayRequestException($e->getMessage());
        }

        $guzzleClient = new Client(
            [
                'base_uri' => $baseApiUrl,
                'http_errors' => false,
            ]
        );

        $allHeaders = new WithAuthAndParams(
            new ByApiKey(new ApiKey($apiKey)),
            [
                'X-REST-TIME-ZONE' => $timezone,
            ]
        );

        return new self($guzzleClient, $allHeaders);
    }

    /**
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public function getWithId(ApiRoute $apiRouteKey, int $modelId): array
    {
        return $this->getModelsInnerContentsFromApi('GET', $apiRouteKey, $modelId);
    }

    /**
     * @param string $getParameters То, что после знака "?" в строке запроса. Например: 'client_id=133'
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public function getContentsWithGetParametersAsString(ApiRoute $apiRouteKey, string $getParameters): array
    {
        $apiDataContents = $this->getWithGetParametersAsString($apiRouteKey, $getParameters);
        return $this->getModelsContentsFromApiResponseDataElement($apiDataContents, $apiRouteKey);
    }

    /**
     * @param string $getParameters То, что после знака "?" в строке запроса. Например: 'client_id=133'
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public function getWithGetParametersAsString(ApiRoute $apiRouteKey, string $getParameters): array
    {
        try {
            $url = (new RestApiPrefix())->asString() . $apiRouteKey->value . '?' . $getParameters;
        } catch (\Exception $e) {
            throw new VetmanagerApiGatewayRequestException($e->getMessage());
        }

        $response = $this->getResponseFromGuzzleClient('GET', $url);
        return $this->getDataContentsFromResponseOrThrowOnFail($response);
    }

    /** Вернет в виде массива либо содержимое модели, либо массив нескольких моделей с такими массивами
     * @param int $maxLimitOfReturnedModels Ограничение по количеству возвращаемых моделей
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public function getContentsWithQueryBuilder(ApiRoute $apiRouteKey, Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        $apiDataContents = $this->getWithQueryBuilder($apiRouteKey, $builder, $maxLimitOfReturnedModels, $pageNumber);
        return $this->getModelsContentsFromApiResponseDataElement($apiDataContents, $apiRouteKey);
    }

    /**
     * @param int $maxLimitOfReturnedModels Ограничение по количеству возвращаемых моделей
     * @param int $pageNumber При использовании пагинации
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public function getWithQueryBuilder(ApiRoute $apiRouteKey, Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        $pagedQuery = $this->getPagedQueryFromQueryBuilder($builder, $maxLimitOfReturnedModels, $pageNumber);
        return self::getWithPagedQuery($apiRouteKey, $pagedQuery, $maxLimitOfReturnedModels);
    }

    private function getPagedQueryFromQueryBuilder(Builder $builder, int $maxLimitOfReturnedModels, int $pageNumber): PagedQuery
    {
        return $builder->paginate($maxLimitOfReturnedModels, $pageNumber);
    }

    /**
     * @param int $maxLimitOfReturnedModels Ограничение по количеству возвращаемых моделей
     *
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public function getWithPagedQuery(ApiRoute $apiRouteKey, PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        $modelResponseKeyInJson = $apiRouteKey->getApiModelResponseKey();
        $arrayOfModelsWithTheirContents = [];

        do {
            $modelDataContents = $this->getModelsDataContentsUsingPagedQueryWithOneRequest($apiRouteKey, $pagedQuery);
            $pagedQuery->next();
            if (!is_array($modelDataContents[$modelResponseKeyInJson])) {
                throw new VetmanagerApiGatewayResponseException(
                    "В Json под ключом '$modelResponseKeyInJson' должна быть строка"
                );
            }
            $arrayOfModelsWithTheirContents = array_merge($arrayOfModelsWithTheirContents, $modelDataContents[$modelResponseKeyInJson]);
        } while (count($arrayOfModelsWithTheirContents) == $maxLimitOfReturnedModels);

        return [
            'totalCount' => $modelDataContents['totalCount'],
            $apiRouteKey->getApiModelResponseKey() => $arrayOfModelsWithTheirContents
        ];
    }

    /**
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    private function getModelsDataContentsUsingPagedQueryWithOneRequest(ApiRoute $apiRouteKey, PagedQuery $pagedQuery): array
    {
        $url = $this->getUrlForGuzzleRequest($apiRouteKey);
        $response = $this->getResponseFromGuzzleClient('GET', $url, pagedQuery: $pagedQuery);
        return $this->getDataContentsFromResponseOrThrowOnFail($response);
    }


    /** Вернет в виде массива либо содержимое модели, либо массив нескольких моделей с такими массивами
     * @param int $maxLimitOfReturnedModels Ограничение по количеству возвращаемых моделей
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public function getContentsWithPagedQuery(ApiRoute $apiRouteKey, PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        $apiDataContents = $this->getWithPagedQuery($apiRouteKey, $pagedQuery, $maxLimitOfReturnedModels);
        return $this->getModelsContentsFromApiResponseDataElement($apiDataContents, $apiRouteKey);
    }

    /**
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public function post(ApiRoute $apiRouteKey, array $data): array
    {
        return $this->getModelsInnerContentsFromApi('POST', $apiRouteKey, data: $data);
    }

    /**
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public function put(ApiRoute $apiRouteKey, int $modelId, array $data): array
    {
        return $this->getModelsInnerContentsFromApi('PUT', $apiRouteKey, $modelId, $data);
    }

    /**
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public function delete(ApiRoute $apiRouteKey, int $modelId): void
    {
        $this->getDataContentsFromResponseFromApi('DELETE', $apiRouteKey, $modelId);
        // Будет возвращаться только ID, который был удален, поэтому игнорируем. При неудаче все равно исключение кидает
    }


    /**
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    private function getModelsInnerContentsFromApi(string $method, ApiRoute $apiRouteKey, int $modelId = 0, array $data = []): array
    {
        $apiDataContents = $this->getDataContentsFromResponseFromApi($method, $apiRouteKey, $modelId, $data);
        return $this->getModelsContentsFromApiResponseDataElement($apiDataContents, $apiRouteKey);
    }

    /**
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    private function getDataContentsFromResponseFromApi(string $method, ApiRoute $apiRouteKey, int $modelId = 0, array $data = []): array
    {
        $url = $this->getUrlForGuzzleRequest($apiRouteKey, $modelId);
        $response = $this->getResponseFromGuzzleClient($method, $url, $data);
        return $this->getDataContentsFromResponseOrThrowOnFail($response);
    }

    /** @throws VetmanagerApiGatewayRequestException */
    private function getUrlForGuzzleRequest(ApiRoute $apiRouteKey, int $modelId = 0): string
    {
        $modelKey = $apiRouteKey->value;
        $uri = ($modelId) ? new WithId(new Model($modelKey), $modelId) : new OnlyModel(new Model($modelKey));

        try {
            return $uri->asString();
        } catch (\Exception $e) {
            throw new VetmanagerApiGatewayRequestException($e->getMessage());
        }
    }

    /**
     * @param array $data Только для POST/PUT методов
     * @throws VetmanagerApiGatewayRequestException
     * @throws VetmanagerApiGatewayResponseException
     */
    private function getResponseFromGuzzleClient(string $method, string $url, array $data = [], ?PagedQuery $pagedQuery = null): ResponseInterface
    {
        $options = $this->getOptionsForGuzzleRequest($data, $pagedQuery);
        try {
            return $this->guzzleClient->request($method, $url, $options);
        } catch (GuzzleException $e) {
            throw new VetmanagerApiGatewayResponseException($e->getMessage());
        }
    }

    /**
     * @return array{headers: array<string, mixed>, body?: false|string, query?: array<string, mixed>}
     * @throws VetmanagerApiGatewayRequestException
     */
    private function getOptionsForGuzzleRequest(array $data = [], ?PagedQuery $pagedQuery = null): array
    {
        $options = ['headers' => $this->allHeaders->asKeyValue()];

        if ($data) {
            $options['body'] = json_encode($data);
        }

        try {
            if ($pagedQuery) {
                $options['query'] = $pagedQuery->asKeyValue();
            }
        } catch (\Exception $e) {
            throw new VetmanagerApiGatewayRequestException($e->getMessage());
        }

        return $options;
    }

    /**
     * @throws VetmanagerApiGatewayResponseEmptyException
     * @throws VetmanagerApiGatewayResponseException
     * @psalm-suppress RedundantCastGivenDocblockType
     */
    private function getDataContentsFromResponseOrThrowOnFail(ResponseInterface $response): array
    {
        $contents = json_decode($response->getBody()->getContents(), true);

        if (empty($contents) || !isset($contents['data'])) {
            throw new VetmanagerApiGatewayResponseEmptyException('Пустой ответ апи');
        }

        if (!filter_var($contents['success'], FILTER_VALIDATE_BOOLEAN)) {
            throw new VetmanagerApiGatewayResponseException(
                $contents['message'] ? (string) $contents['message'] : 'Неизвестная ошибка работы с апи'
            );
        }
        /** @var array{data: array, success: bool, message?: string} $contents */

        return (array)$contents['data'];
    }

    /**
     * @throws VetmanagerApiGatewayResponseException
     */
    private function getModelsContentsFromApiResponseDataElement(array $apiDataContents, ApiRoute $apiRouteKey): array
    {
        $modelKey = $apiRouteKey->getApiModelResponseKey();

        if (!isset($apiDataContents[$modelKey])) {
            throw new VetmanagerApiGatewayResponseException("Не найден ключ модели '$modelKey' в JSON ответе от АПИ");
        }

        return $apiDataContents[$modelKey];
    }
}
