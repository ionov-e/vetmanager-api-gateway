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
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayOverduePaymentException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayUnauthorizedException;

/**
 * @internal
 */
class ApiRequest
{
    public function __construct(
        private readonly Client      $guzzleClient,
        private readonly string      $baseApiUrl,
        private readonly string      $method,
        private readonly string      $pathUrl,
        private readonly array       $data = [],
        private readonly ?PagedQuery $pagedQuery = null
    )
    {
    }

    /** @throws VetmanagerApiGatewayRequestException */
    public static function constructorWithUrlGettingFromModelIdAndRoute(
        Client      $guzzleClient,
        string      $baseApiUrl,
        string      $method,
        string      $modelRouteKey,
        int         $modelId = 0,
        array       $data = [],
        ?PagedQuery $pagedQuery = null
    ): self
    {
        return new self(
            $guzzleClient,
            $baseApiUrl,
            $method,
            self::getPathUrlForGuzzleRequest($modelRouteKey, $modelId),
            $data,
            $pagedQuery
        );
    }

    /** @throws VetmanagerApiGatewayRequestException */
    private static function getPathUrlForGuzzleRequest(string $modelRouteKey, int $modelId = 0): string
    {
        $pathUrlObject = ($modelId) ? new WithId(new Model($modelRouteKey), $modelId) : new OnlyModel(new Model($modelRouteKey));

        try {
            return $pathUrlObject->asString();
        } catch (Exception $e) {
            throw new VetmanagerApiGatewayRequestException("PathUrl Error. modelRouteKey = $modelRouteKey, modelId = $modelId" . $e->getMessage());
        }
    }

    /** @throws VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException */
    public function getModels(string $modelKeyInResponse): array
    {
        $apiResponseAsArray = $this->getResponseAsArray();
        return $this->getModelsFromApiResponseAsArray($apiResponseAsArray, $modelKeyInResponse);
    }

    /** @throws VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException */
    private function getDataContents(): array
    {
        $apiResponseAsArray = $this->getResponseAsArray();
        return $this->getDataContentsFromApiResponseAsArray($apiResponseAsArray);
    }

    /** Так же проверяет ответ
     * @throws VetmanagerApiGatewayRequestException|VetmanagerApiGatewayResponseException
     * @throws VetmanagerApiGatewayOverduePaymentException
     * @throws VetmanagerApiGatewayUnauthorizedException
     */
    public function getResponseAsArray(): array
    {
        $response = $this->getResponse();

        $apiResponseAsArray = json_decode($response->getBody()->getContents(), true);
        $responseStatus = $response->getStatusCode();

        if (!in_array($responseStatus, [200, 201])) {
            $errorMessage = $this->getMessageFromApiResponseAsArray($apiResponseAsArray);

            if ($responseStatus === 401) {
                if (str_contains($errorMessage, 'Tariff expired')) {
                    // В этом случае получаем: "Authorization failed. Tariff expired"
                    throw new VetmanagerApiGatewayOverduePaymentException($errorMessage);
                }

                // Если неправильный ключ получаем: "Authorization failed".
                throw new VetmanagerApiGatewayUnauthorizedException($errorMessage);
            }

            throw new VetmanagerApiGatewayResponseException(
                $this->getStandardExceptionPrefixInfo() . "Получили статус: "
                . $response->getStatusCode() . ". С сообщением: $errorMessage"
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
        return $this->getModelsFromApiResponseDataElement($apiResponseAsArray, $modelKeyInResponse);
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
            $modelsInResponse = $this->getModelsFromApiResponseDataElement($apiResponseDataContents, $modelKeyInResponse);
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

    /** Вернет либо массив с моделью, либо массив с такими моделями в виде массивов
     * @throws VetmanagerApiGatewayResponseException
     */
    private function getModelsFromApiResponseAsArray(array $apiResponseAsArray, string $modelKeyInResponse): array
    {
        $dataContentsFromApiResponse = $this->getDataContentsFromApiResponseAsArray($apiResponseAsArray);
        return $this->getModelsFromApiResponseDataElement($dataContentsFromApiResponse, $modelKeyInResponse);
    }

    /** @throws VetmanagerApiGatewayResponseException */
    private function getDataContentsFromApiResponseAsArray(array $apiResponseAsArray): array
    {
        if (!isset($apiResponseAsArray['data'])) {
            throw new VetmanagerApiGatewayResponseException(
                $this->getStandardExceptionPrefixInfo() . "В ответе отсутствует 'data': "
                . json_encode($apiResponseAsArray, JSON_UNESCAPED_UNICODE)
            );
        }

        if (!is_array($apiResponseAsArray['data'])) {
            throw new VetmanagerApiGatewayResponseException(
                $this->getStandardExceptionPrefixInfo() . "В ответе 'data' не является массивом: "
                . json_encode($apiResponseAsArray, JSON_UNESCAPED_UNICODE)
            );
        }

        return $apiResponseAsArray['data'];
    }

    /** @throws VetmanagerApiGatewayResponseException */
    private function getModelsFromApiResponseDataElement(array $apiDataContents, string $modelKeyInResponse): array
    {
        if (!isset($apiDataContents[$modelKeyInResponse])) {
            throw new VetmanagerApiGatewayResponseException(
                $this->getStandardExceptionPrefixInfo() . "Не найден ключ модели '$modelKeyInResponse' в JSON ответе от АПИ: "
                . json_encode($apiDataContents, JSON_UNESCAPED_UNICODE)
            );
        }

        return $apiDataContents[$modelKeyInResponse];
    }

    /** Текстовое начало каждого выкидываемого исключения в этом классе */
    private function getStandardExceptionPrefixInfo(): string
    {
        try {
            $pagedQueryAsString = is_null($this->pagedQuery) ? "" : ", pagedQuery: " . json_encode($this->pagedQuery->asKeyValue());
        } catch (Exception $e) {
            $pagedQueryAsString = ", pagedQuery->asKeyValue() Исключение: " . $e->getMessage();
        }

        $dataToSendAsString =  empty($this->data) ? "" : ", отправка: " . json_encode($this->data, JSON_UNESCAPED_UNICODE);

        return "Запрос: {$this->baseApiUrl}/{$this->pathUrl}, метод: {$this->method}" . $dataToSendAsString . $pagedQueryAsString . ". Исключение: ";
    }
}