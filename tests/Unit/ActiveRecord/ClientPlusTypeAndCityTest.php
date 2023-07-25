<?php

namespace VetmanagerApiGateway\Unit\ActiveRecord;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use VetmanagerApiGateway\ActiveRecord\ClientPlusTypeAndCity;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO\ClientPlusTypeAndCityDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

#[CoversClass(ClientPlusTypeAndCity::class)]
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

    public function testGetDtoClass()
    {
        $this->assertEquals(ClientPlusTypeAndCityDto::class, ClientPlusTypeAndCity::getDtoClass());
    }

    public function testGetRouteKey()
    {
        $this->assertEquals('client', ClientPlusTypeAndCity::getRouteKey());
    }

    public function testGetModelKeyInResponse()
    {
        $this->assertEquals('client', ClientPlusTypeAndCity::getModelKeyInResponse());
    }

    /** @throws VetmanagerApiGatewayException */
    #[DataProvider('dataProviderClientJson')]
    public function testFromModelAsArray(string $json, string $getMethodName, int|string $expected)
    {
        $modelDtoAsArray = json_decode($json, true);
        $apiGateway = ApiGateway::fromFullUrlAndApiKey("testing", "testing.xxx", "xxx");
        $activeRecord = ClientPlusTypeAndCity::fromSingleModelAsArray($apiGateway, $modelDtoAsArray);
        $this->assertInstanceOf(ClientPlusTypeAndCity::class, $activeRecord);
        $this->assertEquals($expected, $activeRecord->$getMethodName());
    }

    /** @throws VetmanagerApiGatewayException */
    #[DataProvider('dataProviderClientJson')]
    public function testFromSingleDto(string $json, string $getMethodName, int|string $expected)
    {
        $modelDtoAsArray = json_decode($json, true);
        $apiGateway = ApiGateway::fromFullUrlAndApiKey("testing", "testing.xxx", "xxx");
        $dto = $apiGateway->getDtoFactory()->getAsDtoFromSingleModelAsArray($modelDtoAsArray, ClientPlusTypeAndCityDto::class);
        $this->assertInstanceOf(ClientPlusTypeAndCityDto::class, $dto);

        $activeRecord = ClientPlusTypeAndCity::fromSingleDto($apiGateway, $dto);
        $this->assertInstanceOf(ClientPlusTypeAndCity::class, $activeRecord);
        $this->assertEquals($expected, $activeRecord->$getMethodName());
        $this->assertEquals("Временный", $activeRecord->getClientTypeTitle());
    }
}
