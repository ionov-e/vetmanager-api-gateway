<?php

namespace VetmanagerApiGateway\Unit\Facade;

use Otis22\VetmanagerRestApi\Headers\Auth\ApiKey;
use Otis22\VetmanagerRestApi\Headers\Auth\ByApiKey;
use Otis22\VetmanagerRestApi\Headers\WithAuthAndParams;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use VetmanagerApiGateway\ActiveRecord\ClientPlusTypeAndCity;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\ApiService;
use VetmanagerApiGateway\DtoFactory;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade\Client;

#[CoversClass(ClientPlusTypeAndCity::class)]
class ClientTest extends TestCase
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
"last_name": "Last Name",
"first_name": "First Name",
"middle_name": "Middle Name",
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

    /** @throws VetmanagerApiGatewayException */
    #[DataProvider('dataProviderClientJson')]
    public function testCreationFromModelArray(string $json, string $getMethodName, int|string $expected): void
    {
        $apiService = new ApiService(new \GuzzleHttp\Client(), new WithAuthAndParams(new ByApiKey(new ApiKey("testing")), ['X-REST-TIME-ZONE' => '+03:00']));
        $activeRecordFactory = new ActiveRecordFactory(
            $apiService,
            DtoFactory::withDefaultSerializers()
        );
        $clientFacade = new Client($activeRecordFactory);
        $modelAsArray = json_decode($json, true);
        $activeRecord = $clientFacade->fromSingleModelAsArray($modelAsArray);
        $this->assertInstanceOf(\VetmanagerApiGateway\ActiveRecord\Client::class, $activeRecord);
        $this->assertEquals($expected, $activeRecord->$getMethodName());
    }
}