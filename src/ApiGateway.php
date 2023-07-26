<?php

declare(strict_types=1);

namespace VetmanagerApiGateway;

use GuzzleHttp\Client;
use Otis22\VetmanagerRestApi\Headers;
use Otis22\VetmanagerRestApi\Headers\Auth\ApiKey;
use Otis22\VetmanagerRestApi\Headers\Auth\ByApiKey;
use Otis22\VetmanagerRestApi\Headers\Auth\ByServiceApiKey;
use Otis22\VetmanagerRestApi\Headers\Auth\ServiceName;
use Otis22\VetmanagerRestApi\Headers\WithAuthAndParams;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;

final class ApiGateway
{
    private ActiveRecordFactory $activeRecordFactory;

    public function __construct(
        public readonly string      $subDomain,
        public readonly string      $apiUrl,
        private readonly ApiService $apiService,
    )
    {
    }

    public static function fromGuzzleWithHeaders(
        string  $subDomain,
        string  $apiUrl,
        Client  $guzzleClient,
        Headers $allHeaders
    ): self
    {
        $apiService = new ApiService($guzzleClient, $allHeaders);
        return new self(
            $subDomain,
            $apiUrl,
            $apiService
        );
    }

    /** @throws VetmanagerApiGatewayRequestException */
    public static function fromDomainAndServiceNameAndApiKey(
        string $subDomain,
        string $serviceName,
        string $apiKey,
        bool   $isProduction,
        string $timezone = '+03:00'
    ): self
    {
        $baseApiUrl = self::getApiUrlFromSubdomainForProdOrTest($subDomain, $isProduction);
        return self::fromFullUrlAndServiceNameAndApiKey($baseApiUrl, $subDomain, $serviceName, $apiKey, $timezone);
    }

    public static function fromFullUrlAndServiceNameAndApiKey(
        string $baseApiUrl,
        string $subDomain,
        string $serviceName,
        string $apiKey,
        string $timezone = '+03:00'
    ): self
    {
        return self::fromGuzzleWithHeaders(
            $subDomain,
            $baseApiUrl,
            self::getGuzzleClientForServiceNameAndApiKey($baseApiUrl),
            self::getHeadersForServiceNameAndApiKey($serviceName, $apiKey, $timezone)
        );
    }

    private static function getGuzzleClientForServiceNameAndApiKey(string $baseApiUrl): Client
    {
        return new Client(['base_uri' => $baseApiUrl, 'http_errors' => false, 'verify' => false]);
    }

    private static function getHeadersForServiceNameAndApiKey(string $serviceName, string $apiKey, string $timezone): WithAuthAndParams
    {
        return new WithAuthAndParams(
            new ByServiceApiKey(
                new ServiceName($serviceName),
                new ApiKey($apiKey)
            ),
            ['X-REST-TIME-ZONE' => $timezone]
        );
    }

    /** @throws VetmanagerApiGatewayRequestException */
    public static function fromDomainAndApiKey(
        string $subDomain,
        string $apiKey,
        bool   $isProduction,
        string $timezone = '+03:00'
    ): self
    {
        $baseApiUrl = self::getApiUrlFromSubdomainForProdOrTest($subDomain, $isProduction);
        return self::fromFullUrlAndApiKey($subDomain, $baseApiUrl, $apiKey, $timezone);
    }

    public static function fromFullUrlAndApiKey(
        string $subDomain,
        string $baseApiUrl,
        string $apiKey,
        string $timezone = '+03:00'
    ): self
    {
        return self::fromGuzzleWithHeaders(
            $subDomain,
            $baseApiUrl,
            self::getGuzzleClientForApiKey($baseApiUrl),
            self::getHeadersForApiKey($apiKey, $timezone)
        );
    }

    private static function getGuzzleClientForApiKey(string $baseApiUrl): Client
    {
        return new Client(['base_uri' => $baseApiUrl, 'http_errors' => false]);
    }

    private static function getHeadersForApiKey(string $apiKey, string $timezone): WithAuthAndParams
    {
        return new WithAuthAndParams(
            new ByApiKey(new ApiKey($apiKey)),
            ['X-REST-TIME-ZONE' => $timezone]
        );
    }

    /** @throws VetmanagerApiGatewayRequestException */
    private static function getApiUrlFromSubdomainForProdOrTest(string $subDomain, bool $isProduction): string
    {
        try {
            return ($isProduction)
                ? \Otis22\VetmanagerUrl\url($subDomain)->asString()
                : \Otis22\VetmanagerUrl\url_test_env($subDomain)->asString();
        } catch (\Exception $e) {
            throw new VetmanagerApiGatewayRequestException($e->getMessage());
        }
    }

    private function getActiveRecordFactory(): ActiveRecordFactory
    {
        if (!isset ($this->activeRecordFactory)) {
            $this->activeRecordFactory = new ActiveRecordFactory($this->apiService, DtoFactory::withDefaultSerializers());
        }

        return $this->activeRecordFactory;
    }

    public function getClient(): Facade\Client
    {
        return new Facade\Client($this->getActiveRecordFactory());
    }
}
