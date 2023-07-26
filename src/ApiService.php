<?php

namespace VetmanagerApiGateway;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Otis22\VetmanagerRestApi\Headers;
use Otis22\VetmanagerRestApi\Model;
use Otis22\VetmanagerRestApi\Query\Builder;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use Otis22\VetmanagerRestApi\URI\OnlyModel;
use Otis22\VetmanagerRestApi\URI\RestApiPrefix;
use Otis22\VetmanagerRestApi\URI\WithId;
use Psr\Http\Message\ResponseInterface;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

class ApiService
{
    public function __construct(private readonly Client $guzzleClient, private readonly Headers $allHeaders)
    {
    }

    /**
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public function getWithId(string $modelKeyInResponse, string $modelRouteKey, int $modelId): array
    {
        return $this->getModelsInnerContentsFromApi('GET', $modelRouteKey, $modelKeyInResponse, $modelId);
    }

    /**
     * @param string $getParameters То, что после знака "?" в строке запроса. Например: 'client_id=133'
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public function getContentsWithGetParametersAsString(string $modelKeyInResponse, string $modelRouteKey, string $getParameters): array
    {
        $apiDataContents = $this->getWithGetParametersAsString($modelRouteKey, $getParameters);
        return self::getModelsContentsFromApiResponseDataElement($apiDataContents, $modelKeyInResponse);
    }

    /**
     * @param string $getParameters То, что после знака "?" в строке запроса. Например: 'client_id=133'
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public function getWithGetParametersAsString(string $modelRouteKey, string $getParameters): array
    {
        try {
            $url = (new RestApiPrefix())->asString() . $modelRouteKey . '?' . $getParameters;
        } catch (Exception $e) {
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
    public function getContentsWithQueryBuilder(string $modelKeyInResponse, string $modelRouteKey, Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        $apiDataContents = $this->getWithQueryBuilder($modelKeyInResponse, $modelRouteKey, $builder, $maxLimitOfReturnedModels, $pageNumber);
        return self::getModelsContentsFromApiResponseDataElement($apiDataContents, $modelKeyInResponse);
    }

    /**
     * @param int $maxLimitOfReturnedModels Ограничение по количеству возвращаемых моделей
     * @param int $pageNumber При использовании пагинации
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public function getWithQueryBuilder(string $modelKeyInResponse, string $modelRouteKey, Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        $pagedQuery = $this->getPagedQueryFromQueryBuilder($builder, $maxLimitOfReturnedModels, $pageNumber);
        return self::getWithPagedQuery($modelKeyInResponse, $modelRouteKey, $pagedQuery, $maxLimitOfReturnedModels);
    }

    private function getPagedQueryFromQueryBuilder(Builder $builder, int $maxLimitOfReturnedModels, int $pageNumber): PagedQuery
    {
        return $builder->paginate($maxLimitOfReturnedModels, $pageNumber);
    }

    /**
     * @param int $maxLimitOfReturnedModels Ограничение по количеству возвращаемых моделей
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public function getWithPagedQuery(string $modelKeyInResponse, string $modelRouteKey, PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        $arrayOfModelsWithTheirContents = [];

        do {
            $apiResponseDataContents = $this->getModelsDataContentsUsingPagedQueryWithOneRequest($modelRouteKey, $pagedQuery);
            $modelsInResponse = $this->getModelsContentsFromApiResponseDataElement($apiResponseDataContents, $modelKeyInResponse);
            $arrayOfModelsWithTheirContents = array_merge($arrayOfModelsWithTheirContents, $modelsInResponse);
            $pagedQuery->next();
        } while (
            (int)$apiResponseDataContents['totalCount'] < $maxLimitOfReturnedModels &&
            count($arrayOfModelsWithTheirContents) == $maxLimitOfReturnedModels
        );

        return [
            'totalCount' => $apiResponseDataContents['totalCount'],
            $modelKeyInResponse => $arrayOfModelsWithTheirContents
        ];
    }

    /**
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    private function getModelsDataContentsUsingPagedQueryWithOneRequest(string $modelRouteKey, PagedQuery $pagedQuery): array
    {
        $url = $this->getUrlForGuzzleRequest($modelRouteKey);
        $response = $this->getResponseFromGuzzleClient('GET', $url, pagedQuery: $pagedQuery);
        return $this->getDataContentsFromResponseOrThrowOnFail($response);
    }


    /** Вернет в виде массива либо содержимое модели, либо массив нескольких моделей с такими массивами
     * @param int $maxLimitOfReturnedModels Ограничение по количеству возвращаемых моделей
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public function getContentsWithPagedQuery(string $modelRouteKey, string $modelKeyInResponse, PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        $apiDataContents = $this->getWithPagedQuery($modelKeyInResponse, $modelRouteKey, $pagedQuery, $maxLimitOfReturnedModels);
        return self::getModelsContentsFromApiResponseDataElement($apiDataContents, $modelKeyInResponse);
    }

    /**
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public function post(string $modelRouteKey, string $modelKeyInResponse, array $data): array
    {
        return $this->getModelsInnerContentsFromApi('POST', $modelRouteKey, $modelKeyInResponse, data: $data);
    }

    /**
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public function put(string $modelRouteKey, string $modelKeyInResponse, int $modelId, array $data): array
    {
        return $this->getModelsInnerContentsFromApi('PUT', $modelRouteKey, $modelKeyInResponse, $modelId, $data);
    }

    /**
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public function delete(string $modelRouteKey, int $modelId): void
    {
        $this->getDataContentsFromResponseFromApi('DELETE', $modelRouteKey, $modelId);
        // Будет возвращаться только ID, который был удален, поэтому игнорируем. При неудаче все равно исключение кидает
    }


    /**
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    private function getModelsInnerContentsFromApi(string $method, string $modelRouteKey, string $modelKeyInResponse, int $modelId = 0, array $data = []): array
    {
        $apiDataContents = $this->getDataContentsFromResponseFromApi($method, $modelRouteKey, $modelId, $data);
        return self::getModelsContentsFromApiResponseDataElement($apiDataContents, $modelKeyInResponse);
    }

    /**
     * @throws VetmanagerApiGatewayException - общее родительское исключение
     * @throws VetmanagerApiGatewayResponseEmptyException|VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    private function getDataContentsFromResponseFromApi(string $method, string $modelRouteKey, int $modelId = 0, array $data = []): array
    {
        $url = $this->getUrlForGuzzleRequest($modelRouteKey, $modelId);
        $response = $this->getResponseFromGuzzleClient($method, $url, $data);
        return $this->getDataContentsFromResponseOrThrowOnFail($response);
    }

    /** @throws VetmanagerApiGatewayRequestException */
    private function getUrlForGuzzleRequest(string $modelRouteKey, int $modelId = 0): string
    {
        $uri = ($modelId) ? new WithId(new Model($modelRouteKey), $modelId) : new OnlyModel(new Model($modelRouteKey));

        try {
            return $uri->asString();
        } catch (Exception $e) {
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
        } catch (Exception $e) {
            throw new VetmanagerApiGatewayRequestException($e->getMessage());
        }

        return $options;
    }

    /**
     * @return array{data: array, success: bool, message?: string}
     * @throws VetmanagerApiGatewayResponseException
     * @psalm-suppress RedundantCastGivenDocblockType
     * @throws VetmanagerApiGatewayResponseEmptyException
     */
    private function getDataContentsFromResponseOrThrowOnFail(ResponseInterface $response): array
    {
        $contents = json_decode($response->getBody()->getContents(), true);

        if (empty($contents) || !isset($contents['data'])) {
            throw new VetmanagerApiGatewayResponseEmptyException('Пустой ответ апи');
        }

        if (!filter_var($contents['success'], FILTER_VALIDATE_BOOLEAN)) {
            throw new VetmanagerApiGatewayResponseException(
                $contents['message'] ? (string)$contents['message'] : 'Неизвестная ошибка работы с апи'
            );
        }

        return (array)$contents['data'];
    }

    /** @throws VetmanagerApiGatewayResponseException */
    public static function getModelsContentsFromApiResponseDataElement(array $apiDataContents, string $modelKeyInResponse): array
    {
        if (!isset($apiDataContents[$modelKeyInResponse])) {
            throw new VetmanagerApiGatewayResponseException("Не найден ключ модели '$modelKeyInResponse' в JSON ответе от АПИ");
        }

        return $apiDataContents[$modelKeyInResponse];
    }
}