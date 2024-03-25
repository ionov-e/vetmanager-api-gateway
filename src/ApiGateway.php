<?php

declare(strict_types=1);

namespace VetmanagerApiGateway;

use GuzzleHttp\Client;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestUrlDomainException;

final class ApiGateway
{
    private ?ActiveRecordFactory $activeRecordFactory = null;

    /**
     * @param string $fullUrl Полный юрл сервера, типа: "https://three.test.kube-dev.vetmanager.cloud"
     */
    public function __construct(
        public readonly string         $fullUrl,
        private readonly ApiConnection $apiConnection,
    )
    {
    }

    /**
     * @param string $fullUrl Полный юрл сервера, типа: "https://three.test.kube-dev.vetmanager.cloud"
     * @param Client $guzzleClient Должны быть добавлены и хедеры, и базовый юрл
     */
    public static function fromFullUrlAndGuzzleClient(
        string $fullUrl,
        Client $guzzleClient
    ): self
    {
        return new self(
            $fullUrl,
            new ApiConnection($guzzleClient, $fullUrl)
        );
    }

    /** @throws VetmanagerApiGatewayRequestUrlDomainException */
    public static function fromSubdomainAndServiceNameAndApiKey(
        string $subDomain,
        string $serviceName,
        string $apiKey,
        bool   $isProduction,
        string $timezone = '+03:00'
    ): self
    {
        $fullUrl = ApiConnection::getApiUrlFromSubdomainForProdOrTest($subDomain, $isProduction);
        return self::fromFullUrlAndServiceNameAndApiKey($fullUrl, $serviceName, $apiKey, $timezone);
    }

    /**
     * @param string $fullUrl Полный юрл сервера, типа: "https://three.test.kube-dev.vetmanager.cloud"
     */
    public static function fromFullUrlAndServiceNameAndApiKey(
        string $fullUrl,
        string $serviceName,
        string $apiKey,
        string $timezone = '+03:00'
    ): self
    {
        return self::fromFullUrlAndGuzzleClient(
            $fullUrl,
            ApiConnection::getGuzzleClientForServiceNameAndApiKey($fullUrl, $serviceName, $apiKey, $timezone)
        );
    }

    /**
     * @param string $subDomain Лишь субдомен сервера, типа: "three"
     * @throws VetmanagerApiGatewayRequestUrlDomainException
     */
    public static function fromSubdomainAndApiKey(
        string $subDomain,
        string $apiKey,
        bool   $isProduction,
        string $timezone = '+03:00'
    ): self
    {
        $fullUrl = ApiConnection::getApiUrlFromSubdomainForProdOrTest($subDomain, $isProduction);
        return self::fromFullUrlAndApiKey($fullUrl, $apiKey, $timezone);
    }

    /**
     * @param string $fullUrl Полный юрл сервера, типа: "https://three.test.kube-dev.vetmanager.cloud"
     */
    public static function fromFullUrlAndApiKey(
        string $fullUrl,
        string $apiKey,
        string $timezone = '+03:00'
    ): self
    {
        return self::fromFullUrlAndGuzzleClient(
            $fullUrl,
            ApiConnection::getGuzzleClientForApiKey($fullUrl, $apiKey, $timezone)
        );
    }

    private function getActiveRecordFactory(): ActiveRecordFactory
    {
        if (is_null($this->activeRecordFactory)) {
            $this->activeRecordFactory = new ActiveRecordFactory($this->apiConnection, DtoFactory::withDefaultSerializer(), DtoNormalizer::withDefaultSerializer());
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
