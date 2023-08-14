<?php

declare(strict_types=1);

namespace VetmanagerApiGateway;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Otis22\VetmanagerRestApi\Model;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use Otis22\VetmanagerRestApi\URI\OnlyModel;
use Otis22\VetmanagerRestApi\URI\WithId;
use Psr\Http\Message\ResponseInterface;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

/**
 * @internal
 */
class ApiRequest
{
    public function __construct(
        private readonly Client      $guzzleClient,
        private readonly string      $baseApiUrl,
        private readonly string      $pathUrl,
        private readonly string      $method,
        private readonly array       $data = [],
        private readonly ?PagedQuery $pagedQuery = null
    )
    {
    }

    /** @throws VetmanagerApiGatewayRequestException */
    public static function constructorWithUrlGettingFromModelIdAndRoute(
        Client      $guzzleClient,
        string      $baseApiUrl,
        string      $modelRouteKey,
        int         $modelId = 0,
        string      $method,
        array       $data = [],
        ?PagedQuery $pagedQuery = null
    ): self
    {
        return new self(
            $guzzleClient,
            $baseApiUrl,
            self::getPathUrlForGuzzleRequest($modelRouteKey, $modelId),
            $method,
            $data,
            $pagedQuery
        );
    }

    /** @throws VetmanagerApiGatewayRequestException */
    private static function getPathUrlForGuzzleRequest(string $modelRouteKey, int $modelId = 0): string
    {
        $uri = ($modelId) ? new WithId(new Model($modelRouteKey), $modelId) : new OnlyModel(new Model($modelRouteKey));

        try {
            return $uri->asString();
        } catch (Exception $e) {
            throw new VetmanagerApiGatewayRequestException("PathUrl Error. modelRouteKey = $modelRouteKey, modelId = $modelId" . $e->getMessage());
        }
    }

    /** @throws VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException */
    public function getModels(string $modelKeyInResponse): array
    {
        $apiResponseAsArray = $this->getResponseAsArray();
        return self::getModelsFromApiResponseAsArray($apiResponseAsArray, $modelKeyInResponse);
    }

    /** @throws VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException */
    private function getDataContents(): array
    {
        $apiResponseAsArray = $this->getResponseAsArray();
        return self::getDataContentsFromApiResponseAsArray($apiResponseAsArray);
    }

    /** Так же проверяет ответ
     * @throws VetmanagerApiGatewayRequestException|VetmanagerApiGatewayResponseException
     */
    public function getResponseAsArray(): array
    {
        $response = $this->getResponse();

        $apiResponseAsArray = json_decode($response->getBody()->getContents(), true);

        if (!in_array($response->getStatusCode(), [200, 201])) {
            throw new VetmanagerApiGatewayResponseException(
                $this->getStandardExceptionPrefixInfo()
                . "Получили статус: "
                . $response->getStatusCode()
                . ". С сообщением: "
                . $this->getMessageFromApiResponseAsArray($apiResponseAsArray)
            );
        }

        if (!filter_var($apiResponseAsArray['success'], FILTER_VALIDATE_BOOLEAN)) {
            throw new VetmanagerApiGatewayResponseException(
                $this->getStandardExceptionPrefixInfo() . "Получили ошибку: с сообщением: " . $this->getMessageFromApiResponseAsArray($apiResponseAsArray)
            );
        }

        return $apiResponseAsArray;
    }

    private function getMessageFromApiResponseAsArray(array $apiResponseAsArray): string
    {
        return (string)$apiResponseAsArray['message'] ?? '---Не было сообщения---';
    }

    /** @throws VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException */
    public function getModelsUsingMultipleRequests(string $modelKeyInResponse, int $maxLimitOfReturnedModels = 100): array
    {
        $apiResponseAsArray = $this->getDataContentsUsingMultipleRequests($modelKeyInResponse, $maxLimitOfReturnedModels);
        return self::getModelsFromApiResponseDataElement($apiResponseAsArray, $modelKeyInResponse);
    }

    /** Вернет весь ответ в виде массива {totalCount: int, _someModelName_: array}
     * @param int $maxLimitOfReturnedModels Ограничение по количеству возвращаемых моделей
     * @throws VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    private function getDataContentsUsingMultipleRequests(string $modelKeyInResponse, int $maxLimitOfReturnedModels = 100): array
    {
        $arrayOfModelsWithTheirContents = [];

        do {
            $apiResponseDataContents = $this->getDataContents();
            $modelsInResponse = self::getModelsFromApiResponseDataElement($apiResponseDataContents, $modelKeyInResponse);
            $arrayOfModelsWithTheirContents = array_merge($arrayOfModelsWithTheirContents, $modelsInResponse);
            $this->pagedQuery->next();
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
    private function getResponse(): ResponseInterface
    {
        $options = $this->getOptionsForGuzzleRequest();
        try {
            return $this->guzzleClient->request($this->method, $this->pathUrl, $options);
        } catch (GuzzleException $e) {
            throw new VetmanagerApiGatewayResponseException($this->getStandardExceptionPrefixInfo() . $e->getMessage());
        }
    }

    /**
     * @return array{body?: false|string, query?: array<string, mixed>}
     * @throws VetmanagerApiGatewayRequestException
     */
    private function getOptionsForGuzzleRequest(): array
    {
        $options = [];

        if ($this->data) {
            $options['body'] = json_encode($this->data);
        }

        if ($this->pagedQuery) {
            try {
                $options['query'] = $this->pagedQuery->asKeyValue();
            } catch (Exception $e) {
                throw new VetmanagerApiGatewayRequestException($this->getStandardExceptionPrefixInfo() . $e->getMessage());
            }
        }

        return $options;
    }

    private function getStandardExceptionPrefixInfo(): string
    {
        try {
            $pagedQueryAsString = is_null($this->pagedQuery) ? "" : json_encode($this->pagedQuery->asKeyValue());
        } catch (Exception $e) {
            $pagedQueryAsString = "Исключение в 'pagedQuery->asKeyValue()': " . $e->getMessage();
        }

        return "Запрос: {$this->baseApiUrl}/{$this->pathUrl}, метод: {$this->method}, данные: " .
            json_encode($this->data, JSON_UNESCAPED_UNICODE) . $pagedQueryAsString . "Исключение: ";
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
    private static function getDataContentsFromApiResponseAsArray(array $apiResponseAsArray): array
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

    /** @throws VetmanagerApiGatewayResponseException */
    private static function getModelsFromApiResponseDataElement(array $apiDataContents, string $modelKeyInResponse): array
    {
        if (!isset($apiDataContents[$modelKeyInResponse])) {
            throw new VetmanagerApiGatewayResponseException(
                "Не найден ключ модели '$modelKeyInResponse' в JSON ответе от АПИ: " . json_encode($apiDataContents, JSON_UNESCAPED_UNICODE)
            );
        }

        return $apiDataContents[$modelKeyInResponse];
    }
}