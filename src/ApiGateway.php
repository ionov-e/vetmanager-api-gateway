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
            new ByServiceApiKey(new ServiceName($serviceName), new ApiKey($apiKey)),
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

    public function getAdmission(): Facade\Admission
    {
        return new Facade\Admission($this->getActiveRecordFactory());
    }

    public function getBreed(): Facade\Breed
    {
        return new Facade\Breed($this->getActiveRecordFactory());
    }

    public function getCity(): Facade\City
    {
        return new Facade\City($this->getActiveRecordFactory());
    }

    public function getCityType(): Facade\CityType
    {
        return new Facade\CityType($this->getActiveRecordFactory());
    }

    public function getClient(): Facade\Client
    {
        return new Facade\Client($this->getActiveRecordFactory());
    }

    public function getClinic(): Facade\Clinic
    {
        return new Facade\Clinic($this->getActiveRecordFactory());
    }

    public function getComboManualItem(): Facade\ComboManualItem
    {
        return new Facade\ComboManualItem($this->getActiveRecordFactory());
    }

    public function getComboManualName(): Facade\ComboManualName
    {
        return new Facade\ComboManualName($this->getActiveRecordFactory());
    }

    public function getGood(): Facade\Good
    {
        return new Facade\Good($this->getActiveRecordFactory());
    }

    public function getGoodGroup(): Facade\GoodGroup
    {
        return new Facade\GoodGroup($this->getActiveRecordFactory());
    }

    public function getGoodSaleParam(): Facade\GoodSaleParam
    {
        return new Facade\GoodSaleParam($this->getActiveRecordFactory());
    }

    public function getInvoice(): Facade\Invoice
    {
        return new Facade\Invoice($this->getActiveRecordFactory());
    }

    public function getInvoiceDocument(): Facade\InvoiceDocument
    {
        return new Facade\InvoiceDocument($this->getActiveRecordFactory());
    }

    public function getMedicalCard(): Facade\MedicalCard
    {
        return new Facade\MedicalCard($this->getActiveRecordFactory());
    }

    public function getMedicalCardAsVaccination(): Facade\MedicalCardAsVaccination
    {
        return new Facade\MedicalCardAsVaccination($this->getActiveRecordFactory());
    }

    public function getMedicalCardByClient(): Facade\MedicalCardByClient
    {
        return new Facade\MedicalCardByClient($this->getActiveRecordFactory());
    }

    public function getPet(): Facade\Pet
    {
        return new Facade\Pet($this->getActiveRecordFactory());
    }

    public function getPetType(): Facade\PetType
    {
        return new Facade\PetType($this->getActiveRecordFactory());
    }

    public function getProperty(): Facade\Property
    {
        return new Facade\Property($this->getActiveRecordFactory());
    }

    public function getRole(): Facade\Role
    {
        return new Facade\Role($this->getActiveRecordFactory());
    }

    public function getStreet(): Facade\Street
    {
        return new Facade\Street($this->getActiveRecordFactory());
    }

    public function getUnit(): Facade\Unit
    {
        return new Facade\Unit($this->getActiveRecordFactory());
    }

    public function getUser(): Facade\User
    {
        return new Facade\User($this->getActiveRecordFactory());
    }

    public function getUserPosition(): Facade\UserPosition
    {
        return new Facade\UserPosition($this->getActiveRecordFactory());
    }
}
