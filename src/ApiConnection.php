<?php

declare(strict_types=1);

namespace VetmanagerApiGateway;

use Exception;
use GuzzleHttp\Client;
use Otis22\VetmanagerRestApi\Headers\Auth\ApiKey;
use Otis22\VetmanagerRestApi\Headers\Auth\ByApiKey;
use Otis22\VetmanagerRestApi\Headers\Auth\ByServiceApiKey;
use Otis22\VetmanagerRestApi\Headers\Auth\ServiceName;
use Otis22\VetmanagerRestApi\Headers\WithAuthAndParams;
use Otis22\VetmanagerRestApi\Query\Builder;
use Otis22\VetmanagerRestApi\Query\PagedQuery;
use Otis22\VetmanagerRestApi\URI\RestApiPrefix;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestUrlDomainException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

/**
 * @internal
 */
class ApiConnection
{
    /**
     * @param string $baseApiUrl Полный юрл сервера, типа: "https://three.test.kube-dev.vetmanager.cloud"
     */
    public function __construct(
        private readonly Client $guzzleClient,
        private readonly string $baseApiUrl
    ) {
    }

    public static function getGuzzleClientForServiceNameAndApiKey(string $baseApiUrl, string $serviceName, string $apiKey, string $timezone): Client
    {
        $headers = new WithAuthAndParams(
            new ByServiceApiKey(new ServiceName($serviceName), new ApiKey($apiKey)),
            ['X-REST-TIME-ZONE' => $timezone]
        );
        return new Client(['base_uri' => $baseApiUrl, 'http_errors' => false, 'verify' => false, 'headers' => $headers->asKeyValue()]);
    }

    public static function getGuzzleClientForApiKey(string $baseApiUrl, string $apiKey, string $timezone): Client
    {
        $headers = self::getHeadersForApiKey($apiKey, $timezone);
        return new Client(['base_uri' => $baseApiUrl, 'http_errors' => false, 'headers' => $headers->asKeyValue()]);
    }

    public static function getHeadersForApiKey(string $apiKey, string $timezone): WithAuthAndParams
    {
        return new WithAuthAndParams(
            new ByApiKey(new ApiKey($apiKey)),
            ['X-REST-TIME-ZONE' => $timezone]
        );
    }

    /** @throws VetmanagerApiGatewayRequestUrlDomainException */
    public static function getApiUrlFromSubdomainForProdOrTest(string $subDomain, bool $isProduction): string
    {
        try {
            return ($isProduction)
                ? \Otis22\VetmanagerUrl\url($subDomain)->asString()
                : \Otis22\VetmanagerUrl\url_test_env($subDomain)->asString();
        } catch (\Exception $e) {
            $testOrProduction = $isProduction ? "прод" : "тест";
            throw new VetmanagerApiGatewayRequestUrlDomainException(
                "Не получили fullUrl ($testOrProduction) для домена: $subDomain: " . $e->getMessage()
            );
        }
    }

    /** Возвращает только модель в виде массива
     * @throws VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public function getModelById(string $modelKeyInResponse, string $modelRouteKey, int $modelId): array
    {
        return ApiRequest::constructorWithUrlGettingFromModelIdAndRoute($this->guzzleClient, $this->baseApiUrl, 'GET', $modelRouteKey, $modelId)
            ->getModels($modelKeyInResponse);
    }

    /** В зависимости от отправленной строки в пути - вернет либо одна модель в виде массива либо массив с такими моделями
     * @param string $getParameters То, что после знака "?" в строке запроса. Например: 'client_id=133'
     * @throws VetmanagerApiGatewayRequestException|VetmanagerApiGatewayResponseException
     */
    public function getModelsWithGetParametersAsString(string $modelKeyInResponse, string $modelRouteKey, string $getParameters): array
    {
        try {
            $pathUrl = (new RestApiPrefix())->asString() . $modelRouteKey . '?' . $getParameters;
        } catch (Exception $e) {
            throw new VetmanagerApiGatewayRequestException($e->getMessage());
        }

        return (new ApiRequest($this->guzzleClient, $this->baseApiUrl, 'GET', $pathUrl))->getModels($modelKeyInResponse);
    }

    /** Вернет массив с моделями в виде массивов
     * @param int $maxLimitOfReturnedModels Ограничение по количеству возвращаемых моделей
     * @throws VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public function getModelsWithQueryBuilder(string $modelKeyInResponse, string $modelRouteKey, Builder $builder, int $maxLimitOfReturnedModels = 100, int $pageNumber = 0): array
    {
        $pagedQuery = $builder->paginate($maxLimitOfReturnedModels, $pageNumber);
        return  ApiRequest::constructorWithUrlGettingFromModelIdAndRoute($this->guzzleClient, $this->baseApiUrl, 'GET', $modelRouteKey, pagedQuery: $pagedQuery)
            ->getModelsUsingMultipleRequests($modelKeyInResponse, $maxLimitOfReturnedModels);
    }

    /** Вернет массив с моделями в виде массивов
     * @param int $maxLimitOfReturnedModels Ограничение по количеству возвращаемых моделей
     * @throws VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public function getModelsWithPagedQuery(string $modelKeyInResponse, string $modelRouteKey, PagedQuery $pagedQuery, int $maxLimitOfReturnedModels = 100): array
    {
        return ApiRequest::constructorWithUrlGettingFromModelIdAndRoute($this->guzzleClient, $this->baseApiUrl, 'GET', $modelRouteKey, pagedQuery: $pagedQuery)
            ->getModelsUsingMultipleRequests($modelKeyInResponse, $maxLimitOfReturnedModels);
    }

    /** Вернет массив с содержимым отправленной модели
     * @throws VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public function post(string $modelRouteKey, string $modelKeyInResponse, array $data): array
    {
        return ApiRequest::constructorWithUrlGettingFromModelIdAndRoute($this->guzzleClient, $this->baseApiUrl, 'POST', $modelRouteKey, data: $data)
            ->getModels($modelKeyInResponse);
    }

    /** Вернет массив с содержимым отправленной модели
     * @throws VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException
     */
    public function put(string $modelRouteKey, string $modelKeyInResponse, int $modelId, array $data): array
    {
        return ApiRequest::constructorWithUrlGettingFromModelIdAndRoute($this->guzzleClient, $this->baseApiUrl, 'PUT', $modelRouteKey, $modelId, $data)
            ->getModels($modelKeyInResponse);
    }

    /** @throws VetmanagerApiGatewayResponseException|VetmanagerApiGatewayRequestException */
    public function delete(string $modelRouteKey, int $modelId): void
    {
        ApiRequest::constructorWithUrlGettingFromModelIdAndRoute($this->guzzleClient, $this->baseApiUrl, 'DELETE', $modelRouteKey, $modelId)
            ->getResponseAsArray();
        // Будет возвращаться только ID, который был удален, поэтому игнорируем. При неудаче все равно исключение кидает
    }
}



