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
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

class ApiService
{
    public function __construct(private readonly Client $guzzleClient, private readonly Headers $allHeaders)
    {
    }

    /** Возвращает только модель в виде массива
     * @throws VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public function getModelById(string $modelKeyInResponse, string $modelRouteKey, int $modelId): array
    {
        return $this->getModelsAfterApiRequest('GET', $modelRouteKey, $modelKeyInResponse, $modelId);
    }

    /** В зависимости от отправленной строки в пути - вернет либо одна модель в виде массива либо массив с такими моделями
     * @param string $getParameters То, что после знака "?" в строке запроса. Например: 'client_id=133'
     * @throws VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public function getModelsWithGetParametersAsString(string $modelKeyInResponse, string $modelRouteKey, string $getParameters): array
    {
        $apiDataContents = $this->getWithGetParametersAsString($modelRouteKey, $getParameters);
        return self::getModelsFromApiResponseDataElement($apiDataContents, $modelKeyInResponse);
    }

    /** Вернет весь ответ в виде массива {success: true, message: ..., data: {...}}
     * @param string $getParameters То, что после знака "?" в строке запроса. Например: 'client_id=133'
     * @throws VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public function getWithGetParametersAsString(string $modelRouteKey, string $getParameters): array
    {
        try {
            $url = (new RestApiPrefix())->asString() . $modelRouteKey . '?' . $getParameters;
        } catch (Exception $e) {
            throw new VetmanagerApiGatewayRequestException($e->getMessage());
        }

        $response = $this->getResponseAfterApiRequest('GET', $url);
        return $this->getDataContentsFromResponse($response);
    }

    /** Вернет массив с моделями в виде массивов
     * @param int $maxLimitOfReturnedModels Ограничение по количеству возвращаемых моделей
     * @throws VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public function getModelsWithQueryBuilder(string $modelKeyInResponse, string $modelRouteKey, Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        $apiDataContents = $this->getWithQueryBuilder($modelKeyInResponse, $modelRouteKey, $builder, $maxLimitOfReturnedModels, $pageNumber);
        return self::getModelsFromApiResponseDataElement($apiDataContents, $modelKeyInResponse);
    }

    /** Вернет весь ответ в виде массива {success: true, message: ..., data: {...}}
     * @param int $maxLimitOfReturnedModels Ограничение по количеству возвращаемых моделей
     * @param int $pageNumber При использовании пагинации
     * @throws VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public function getWithQueryBuilder(string $modelKeyInResponse, string $modelRouteKey, Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        $pagedQuery = $this->getPagedQueryFromQueryBuilder($builder, $maxLimitOfReturnedModels, $pageNumber);
        return $this->getWithPagedQuery($modelKeyInResponse, $modelRouteKey, $pagedQuery, $maxLimitOfReturnedModels);
    }

    private function getPagedQueryFromQueryBuilder(Builder $builder, int $maxLimitOfReturnedModels, int $pageNumber): PagedQuery
    {
        return $builder->paginate($maxLimitOfReturnedModels, $pageNumber);
    }

    /** Вернет весь ответ в виде массива {success: true, message: ..., data: {...}}
     * @param int $maxLimitOfReturnedModels Ограничение по количеству возвращаемых моделей
     * @throws VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public function getWithPagedQuery(string $modelKeyInResponse, string $modelRouteKey, PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        $arrayOfModelsWithTheirContents = [];

        do {
            $apiResponseDataContents = $this->getModelsDataContentsUsingPagedQueryWithOneRequest($modelRouteKey, $pagedQuery);
            $modelsInResponse = self::getModelsFromApiResponseDataElement($apiResponseDataContents, $modelKeyInResponse);
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

    /** @throws VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException */
    private function getModelsDataContentsUsingPagedQueryWithOneRequest(string $modelRouteKey, PagedQuery $pagedQuery): array
    {
        $url = $this->getUrlForGuzzleRequest($modelRouteKey);
        $response = $this->getResponseAfterApiRequest('GET', $url, pagedQuery: $pagedQuery);
        return $this->getDataContentsFromResponse($response);
    }


    /** Вернет массив с содержимым модели, либо массив нескольких моделей с такими массивами моделей
     * @param int $maxLimitOfReturnedModels Ограничение по количеству возвращаемых моделей
     * @throws VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public function getContentsWithPagedQuery(string $modelRouteKey, string $modelKeyInResponse, PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        $apiDataContents = $this->getWithPagedQuery($modelKeyInResponse, $modelRouteKey, $pagedQuery, $maxLimitOfReturnedModels);
        return self::getModelsFromApiResponseDataElement($apiDataContents, $modelKeyInResponse);
    }

    /** Вернет массив с содержимым отправленной модели
     * @throws VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public function post(string $modelRouteKey, string $modelKeyInResponse, array $data): array
    {
        return $this->getModelsAfterApiRequest('POST', $modelRouteKey, $modelKeyInResponse, data: $data);
    }

    /** Вернет массив с содержимым отправленной модели
     * @throws VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public function put(string $modelRouteKey, string $modelKeyInResponse, int $modelId, array $data): array
    {
        return $this->getModelsAfterApiRequest('PUT', $modelRouteKey, $modelKeyInResponse, $modelId, $data);
    }

    /** @throws VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException */
    public function delete(string $modelRouteKey, int $modelId): void
    {
        $this->getDataContentsAfterApiRequest('DELETE', $modelRouteKey, $modelId);
        // Будет возвращаться только ID, который был удален, поэтому игнорируем. При неудаче все равно исключение кидает
    }


    /** @throws VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException */
    private function getModelsAfterApiRequest(string $method, string $modelRouteKey, string $modelKeyInResponse, int $modelId = 0, array $data = []): array
    {
        $apiDataContents = $this->getDataContentsAfterApiRequest($method, $modelRouteKey, $modelId, $data);
        return self::getModelsFromApiResponseDataElement($apiDataContents, $modelKeyInResponse);
    }

    /** @throws VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException */
    private function getDataContentsAfterApiRequest(string $method, string $modelRouteKey, int $modelId = 0, array $data = []): array
    {
        $url = $this->getUrlForGuzzleRequest($modelRouteKey, $modelId);
        $response = $this->getResponseAfterApiRequest($method, $url, $data);
        return $this->getDataContentsFromResponse($response);
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
     * @throws VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    private function getResponseAfterApiRequest(string $method, string $url, array $data = [], ?PagedQuery $pagedQuery = null): ResponseInterface
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
     */
    private function getDataContentsFromResponse(ResponseInterface $response): array
    {
        $apiResponseAsArray = json_decode($response->getBody()->getContents(), true);
        return self::getDataContentsFromApiResponseAsArray($apiResponseAsArray);
    }

    /** Вернет либо массив с моделью, либо массив с такими моделями в виде массивов
     * @throws VetmanagerApiGatewayResponseException
     */
    public static function getModelsFromApiResponseAsArray(array $apiResponseAsArray, string $modelKeyInResponse): array
    {
        $apiDataContents = self::getDataContentsFromApiResponseAsArray($apiResponseAsArray);
        return self::getModelsFromApiResponseDataElement($apiDataContents, $modelKeyInResponse);
    }

    /**
     * @return array{data: array, success: bool, message?: string}
     * @throws VetmanagerApiGatewayResponseException
     * @psalm-suppress RedundantCastGivenDocblockType
     */
    public static function getDataContentsFromApiResponseAsArray (array $apiResponseAsArray): array
    {
        if (empty($apiResponseAsArray) || !isset($apiResponseAsArray['data'])) {
            throw new VetmanagerApiGatewayResponseException('Пустой ответ апи');
        }

        if (!filter_var($apiResponseAsArray['success'], FILTER_VALIDATE_BOOLEAN)) {
            throw new VetmanagerApiGatewayResponseException(
                $apiResponseAsArray['message'] ? (string)$apiResponseAsArray['message'] : 'Неизвестная ошибка работы с апи'
            );
        }

        return (array)$apiResponseAsArray['data'];
    }

    /** @throws VetmanagerApiGatewayResponseException */
    public static function getModelsFromApiResponseDataElement(array $apiDataContents, string $modelKeyInResponse): array
    {
        if (!isset($apiDataContents[$modelKeyInResponse])) {
            throw new VetmanagerApiGatewayResponseException("Не найден ключ модели '$modelKeyInResponse' в JSON ответе от АПИ");
        }

        return $apiDataContents[$modelKeyInResponse];
    }
}