<?php

declare(strict_types=1);

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
     * @throws VetmanagerApiGatewayRequestException|VetmanagerApiGatewayResponseException
     */
    public function getModelsWithGetParametersAsString(string $modelKeyInResponse, string $modelRouteKey, string $getParameters): array
    {
        try {
            $url = (new RestApiPrefix())->asString() . $modelRouteKey . '?' . $getParameters;
        } catch (Exception $e) {
            throw new VetmanagerApiGatewayRequestException($e->getMessage());
        }

        $apiRequestAsArray = $this->getApiRequestAsArrayAfterRequestUsingUrl('GET', $url);
        $dataContentsFromApiResponse = self::getDataContentsFromApiResponseAsArray($apiRequestAsArray);
        return self::getModelsFromApiResponseDataElement($dataContentsFromApiResponse, $modelKeyInResponse);
    }

    /** Вернет массив с моделями в виде массивов
     * @param int $maxLimitOfReturnedModels Ограничение по количеству возвращаемых моделей
     * @throws VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public function getModelsWithQueryBuilder(string $modelKeyInResponse, string $modelRouteKey, Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        $apiDataContents = $this->getResponseWithQueryBuilder($modelKeyInResponse, $modelRouteKey, $builder, $maxLimitOfReturnedModels, $pageNumber);
        return self::getModelsFromApiResponseDataElement($apiDataContents, $modelKeyInResponse);
    }

    /** Вернет весь ответ в виде массива {success: true, message: ..., data: {...}}
     * @param int $maxLimitOfReturnedModels Ограничение по количеству возвращаемых моделей
     * @param int $pageNumber При использовании пагинации
     * @throws VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public function getResponseWithQueryBuilder(string $modelKeyInResponse, string $modelRouteKey, Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        $pagedQuery = $this->getPagedQueryFromQueryBuilder($builder, $maxLimitOfReturnedModels, $pageNumber);
        return $this->getResponseWithPagedQuery($modelKeyInResponse, $modelRouteKey, $pagedQuery, $maxLimitOfReturnedModels);
    }

    private function getPagedQueryFromQueryBuilder(Builder $builder, int $maxLimitOfReturnedModels, int $pageNumber): PagedQuery
    {
        return $builder->paginate($maxLimitOfReturnedModels, $pageNumber);
    }

    /** Вернет массив с моделями в виде массивов
     * @param int $maxLimitOfReturnedModels Ограничение по количеству возвращаемых моделей
     * @throws VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public function getModelsWithPagedQuery(string $modelKeyInResponse, string $modelRouteKey, PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        $apiResponseAsArray = $this->getResponseWithPagedQuery($modelKeyInResponse, $modelRouteKey, $pagedQuery, $maxLimitOfReturnedModels);
        return self::getModelsFromApiResponseAsArray($apiResponseAsArray, $modelKeyInResponse);
    }


    /** Вернет весь ответ в виде массива {success: true, message: ..., data: {...}}
     * @param int $maxLimitOfReturnedModels Ограничение по количеству возвращаемых моделей
     * @throws VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public function getResponseWithPagedQuery(string $modelKeyInResponse, string $modelRouteKey, PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        $arrayOfModelsWithTheirContents = [];

        do {
            $apiResponseDataContents = $this->getDataContentsUsingPagedQueryWithOneRequest($modelRouteKey, $pagedQuery);
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
    private function getDataContentsUsingPagedQueryWithOneRequest(string $modelRouteKey, PagedQuery $pagedQuery): array
    {
        $url = $this->getUrlForGuzzleRequest($modelRouteKey);
        $response = $this->getResponseAfterDoingApiRequest('GET', $url, pagedQuery: $pagedQuery);
        $apiResponseAsArray = $this->getResponseAsArrayFromResponse($response);
        return self::getDataContentsFromApiResponseAsArray($apiResponseAsArray);
    }

    /** Вернет массив с содержимым модели, либо массив нескольких моделей с такими массивами моделей
     * @param int $maxLimitOfReturnedModels Ограничение по количеству возвращаемых моделей
     * @throws VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public function getModelsOrModelWithPagedQuery(string $modelRouteKey, string $modelKeyInResponse, PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        $apiDataContents = $this->getResponseWithPagedQuery($modelKeyInResponse, $modelRouteKey, $pagedQuery, $maxLimitOfReturnedModels);
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
        $this->getApiRequestAsArrayAfterRequestUsingRouteKeyAndId('DELETE', $modelRouteKey, $modelId);
        // Будет возвращаться только ID, который был удален, поэтому игнорируем. При неудаче все равно исключение кидает
    }

    /** @throws VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException */
    private function getModelsAfterApiRequest(string $method, string $modelRouteKey, string $modelKeyInResponse, int $modelId = 0, array $data = []): array
    {
        $apiResponseAsArray = $this->getApiRequestAsArrayAfterRequestUsingRouteKeyAndId($method, $modelRouteKey, $modelId, $data);
        return self::getModelsFromApiResponseAsArray($apiResponseAsArray, $modelKeyInResponse);
    }

    /** @throws VetmanagerApiGatewayRequestException|VetmanagerApiGatewayResponseException */
    private function getApiRequestAsArrayAfterRequestUsingRouteKeyAndId(string $method, string $modelRouteKey, int $modelId = 0, array $data = []): array
    {
        $url = $this->getUrlForGuzzleRequest($modelRouteKey, $modelId);
        return $this->getApiRequestAsArrayAfterRequestUsingUrl($method, $url, $data);
    }

    /** @throws VetmanagerApiGatewayRequestException|VetmanagerApiGatewayResponseException */
    private function getApiRequestAsArrayAfterRequestUsingUrl(string $method, string $url, array $data = []): array
    {
        $response = $this->getResponseAfterDoingApiRequest($method, $url, $data);
        return $this->getResponseAsArrayFromResponse($response);
    }

    /** @throws VetmanagerApiGatewayResponseException */
    private function getResponseAsArrayFromResponse(ResponseInterface $response): array
    {
        $apiResponseAsArray = json_decode($response->getBody()->getContents(), true);

        if ($response->getStatusCode() !== 200) {
            throw new VetmanagerApiGatewayResponseException(
                "Получили статус: "
                . $response->getStatusCode()
                . ". С сообщением: "
                . self::getMessageFromApiResponseAsArray($apiResponseAsArray)
            );
        }

        if (!filter_var($apiResponseAsArray['success'], FILTER_VALIDATE_BOOLEAN)) {
            throw new VetmanagerApiGatewayResponseException(
                "Получили ошибку: с сообщением: " . self::getMessageFromApiResponseAsArray($apiResponseAsArray)
            );
        }

        return $apiResponseAsArray;
    }

    private static function getMessageFromApiResponseAsArray(array $apiResponseAsArray): string
    {
        return $apiResponseAsArray['message'] ?? '---Не было сообщения---';
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
    private function getResponseAfterDoingApiRequest(string $method, string $url, array $data = [], ?PagedQuery $pagedQuery = null): ResponseInterface
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

    /** @throws VetmanagerApiGatewayResponseException */
    public static function getDataContentsFromApiResponseAsArray(array $apiResponseAsArray): array
    {
        if (!isset($apiResponseAsArray['data'])) {
            throw new VetmanagerApiGatewayResponseException(
                "В ответе от АПИ: отсутствует элемент 'data': " . json_encode($apiResponseAsArray, JSON_UNESCAPED_UNICODE)
            );
        }

        if (!is_array($apiResponseAsArray['data'])) {
            throw new VetmanagerApiGatewayResponseException(
                "В ответе от АПИ: элемент 'data' не является массивом: " . json_encode($apiResponseAsArray, JSON_UNESCAPED_UNICODE)
            );
        }

        return $apiResponseAsArray['data'];
    }

    /** Вернет либо массив с моделью, либо массив с такими моделями в виде массивов
     * @throws VetmanagerApiGatewayResponseException
     */
    public static function getModelsFromApiResponseAsArray(array $apiResponseAsArray, string $modelKeyInResponse): array
    {
        $dataContentsFromApiResponse = self::getDataContentsFromApiResponseAsArray($apiResponseAsArray);
        return self::getModelsFromApiResponseDataElement($dataContentsFromApiResponse, $modelKeyInResponse);
    }

    /** @throws VetmanagerApiGatewayResponseException */
    public static function getModelsFromApiResponseDataElement(array $apiDataContents, string $modelKeyInResponse): array
    {
        if (!isset($apiDataContents[$modelKeyInResponse])) {
            throw new VetmanagerApiGatewayResponseException(
                "Не найден ключ модели '$modelKeyInResponse' в JSON ответе от АПИ: " . json_encode($apiDataContents, JSON_UNESCAPED_UNICODE)
            );
        }

        return $apiDataContents[$modelKeyInResponse];
    }
}