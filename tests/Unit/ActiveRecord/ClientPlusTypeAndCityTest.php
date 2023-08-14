<?php

namespace VetmanagerApiGateway\Unit\ActiveRecord;

use GuzzleHttp\Client;
use Otis22\VetmanagerRestApi\Headers\Auth\ApiKey;
use Otis22\VetmanagerRestApi\Headers\Auth\ByApiKey;
use Otis22\VetmanagerRestApi\Headers\WithAuthAndParams;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\ActiveRecord\Client\ClientOnly;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\ApiConnection;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO\Client\ClientOnlyDto;
use VetmanagerApiGateway\DTO\Client\ClientPlusTypeAndCityDto;
use VetmanagerApiGateway\DtoFactory;
use VetmanagerApiGateway\DtoNormalizer;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade;

#[CoversClass(ActiveRecord\Client\ClientPlusTypeAndCity::class)]
#[CoversClass(ClientPlusTypeAndCityDto::class)]
#[CoversClass(ClientOnlyDto::class)]
#[CoversClass(ClientOnly::class)]
#[CoversClass(Facade\Client::class)]
class ClientPlusTypeAndCityTest extends TestCase
{
    public static function dataProviderClientJson(): array
    {
        return [
            [
                /** @lang JSON */
                <<<'EOF'
{
"id": "1",
"address": "",
"home_phone": "3322122",
"work_phone": "2234354",
"note": "",
"type_id": "3",
"how_find": "15",
"balance": "532.1900000000",
"email": "neelena10@gmail.com",
"city": "",
"city_id": "251",
"date_register": "2012-09-29 09:14:34",
"cell_phone": "(232)131-23-11",
"zip": "",
"registration_index": null,
"vip": "0",
"last_name": "Last Enum",
"first_name": "First Enum",
"middle_name": "Middle Enum",
"status": "ACTIVE",
"discount": "3",
"passport_series": "",
"lab_number": "",
"street_id": "0",
"apartment": "",
"unsubscribe": "0",
"in_blacklist": "0",
"last_visit_date": "2023-07-06 12:20:19",
"number_of_journal": "",
"phone_prefix": "38",
            "city_data": {
                "id": "251",
                "title": "Ваш город",
                "type_id": "1"
            },
            "client_type_data": {
                "id": "3",
                "title": "Временный"
            }
}
EOF
                , "getId", 1]
        ];
    }

    public function testGetDtoClass()
    {
        $this->assertEquals(ClientPlusTypeAndCityDto::class, ActiveRecord\Client\ClientPlusTypeAndCity::getDtoClass());
    }

    public function testGetRouteKey()
    {
        $this->assertEquals('client', ActiveRecord\Client\ClientPlusTypeAndCity::getRouteKey());
    }

    public function testGetModelKeyInResponse()
    {
        $this->assertEquals('client', ActiveRecord\Client\ClientPlusTypeAndCity::getModelKeyInResponse());
    }

    /** @throws VetmanagerApiGatewayException */
    #[DataProvider('dataProviderClientJson')]
    public function testFromModelAsArray(string $json, string $getMethodName, int|string $expected): void
    {
        $modelAsArray = json_decode($json, true);
        $apiGateway = ApiGateway::fromFullUrlAndApiKey("testing", "testing.xxx", "xxx");
        $clientFacade = $apiGateway->getClient();
        $this->assertInstanceOf(\VetmanagerApiGateway\Facade\Client::class, $clientFacade);
        $activeRecord = $clientFacade->fromSingleModelAsArray($modelAsArray);
        $this->assertInstanceOf(ClientOnly::class, $activeRecord);
        $this->assertEquals($expected, $activeRecord->$getMethodName());
    }

    /** @throws VetmanagerApiGatewayException */
    #[DataProvider('dataProviderClientJson')]
    public function testFromSingleDtoAndGetClientPlusActiveRecord(string $json, string $getMethodName, int|string $expected): void
    {
        $modelAsArray = json_decode($json, true);
        $dto = DtoFactory::withDefaultSerializer()->getFromSingleModelAsArray($modelAsArray, ClientPlusTypeAndCityDto::class);
        $apiService = new ApiConnection(new Client(), new WithAuthAndParams(new ByApiKey(new ApiKey("testing")), ['X-REST-TIME-ZONE' => '+03:00']));
        $activeRecordFactory = new ActiveRecordFactory(
            $apiService,
            DtoFactory::withDefaultSerializer(),
            DtoNormalizer::withDefaultSerializer()
        );
        $activeRecordClient = $activeRecordFactory->getFromSingleDto($dto, ActiveRecord\Client\ClientPlusTypeAndCity::class);
        $this->assertInstanceOf(ActiveRecord\Client\ClientPlusTypeAndCity::class, $activeRecordClient);
        $activeRecordCity = $activeRecordClient->getCity();
        $this->assertInstanceOf(ActiveRecord\City\City::class, $activeRecordCity);
        $this->assertEquals(251, $activeRecordCity->getId());
        $this->assertEquals("Временный", $activeRecordClient->getClientTypeTitle());
    }
}
