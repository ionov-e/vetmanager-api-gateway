<?php

namespace ActiveRecord;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use VetmanagerApiGateway\ActiveRecord;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO\MedicalCard\MedicalCardPlusPetDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade;

#[CoversClass(ActiveRecord\MedicalCard\MedicalCardPlusPet::class)]
#[CoversClass(MedicalCardPlusPetDto::class)]
class MedicalCardPlusPetTest extends TestCase
{
    public static function dataProviderWithIntegersJson(): array
    {
        return [[
            /** @lang JSON */
            <<<'EOF'
{
    "id": 1,
    "patient_id": 1,
    "date_create": "2019-07-06 14:00:01",
    "date_edit": "2020-11-04 12:26:00",
    "diagnos": "[{\"id\":\"32\",\"type\":1},{\"id\":\"11\",\"type\":1}]",
    "recomendation": "upd recomendation",
    "invoice": null,
    "admission_type": 7,
    "weight": "0.0000000000",
    "temperature": "0.0000000000",
    "meet_result_id": 0,
    "description": "10245",
    "next_meet_id": 0,
    "doctor_id": 1,
    "creator_id": 2,
    "status": "active",
    "calling_id": 0,
    "admission_id": 10,
    "diagnos_text": "",
    "diagnos_type_text": "",
    "clinic_id": 1,
    "patient": {
        "id": 1,
        "owner_id": 1,
        "type_id": 1,
        "alias": "Тест",
        "sex": "female",
        "date_register": "2013-10-17 10:24:05",
        "birthday": "2012-09-01",
        "note": "",
        "breed_id": 1,
        "old_id": null,
        "color_id": 1,
        "deathnote": null,
        "deathdate": null,
        "chip_number": "",
        "lab_number": "",
        "status": "alive",
        "picture": null,
        "weight": "5.0000000000",
        "edit_date": "2022-11-21 14:13:45"
    }
}
EOF
            , "getId", 1]];
    }

    public static function dataProviderWithStringsJson(): array
    {
        return [[
            /** @lang JSON */
            <<<'EOF'
{
        "id": "2",
        "patient_id": "4",
        "date_create": "2020-05-13 12:22:00",
        "date_edit": "2020-05-13 12:22:00",
        "diagnos": "0",
        "recomendation": "",
        "invoice": null,
        "admission_type": "7",
        "weight": "0.0000000000",
        "temperature": "0.0000000000",
        "meet_result_id": "0",
        "description": "<div></div>",
        "next_meet_id": "0",
        "doctor_id": "10",
        "creator_id": "2",
        "status": "active",
        "calling_id": "0",
        "admission_id": "2",
        "diagnos_text": "",
        "diagnos_type_text": "",
        "clinic_id": "1",
        "patient": {
            "id": "4",
            "owner_id": "6",
            "type_id": "2",
            "alias": "Мона",
            "sex": "female",
            "date_register": "2020-05-13 12:21:43",
            "birthday": "2018-05-13",
            "note": "",
            "breed_id": "331",
            "old_id": null,
            "color_id": "0",
            "deathnote": null,
            "deathdate": null,
            "chip_number": "",
            "lab_number": "",
            "status": "alive",
            "picture": null,
            "weight": "0.0000000000",
            "edit_date": "2022-11-23 09:47:03"
        }
}
EOF
            , "getId", 2]];
    }

    public function testGetDtoClass()
    {
        $this->assertEquals(MedicalCardPlusPetDto::class, ActiveRecord\MedicalCard\MedicalCardPlusPet::getDtoClass());
    }

    public function testGetRouteKey()
    {
        $this->assertEquals('medicalCards', ActiveRecord\MedicalCard\MedicalCardPlusPet::getRouteKey());
    }

    public function testGetModelKeyInResponse()
    {
        $this->assertEquals('medicalCards', ActiveRecord\MedicalCard\MedicalCardPlusPet::getModelKeyInResponse());
    }

    /** @throws VetmanagerApiGatewayException */
    #[DataProvider('dataProviderWithIntegersJson')]
    public function testFromArrayWithIntegers(string $json, string $getMethodName, int|string $expected): void
    {
        $modelAsArray = json_decode($json, true);
        $apiGateway = ApiGateway::fromFullUrlAndApiKey("testing", "testing.xxx", "xxx");
        $medicalCardFacade = $apiGateway->getMedicalCard();
        $this->assertInstanceOf(Facade\MedicalCard::class, $medicalCardFacade);
        $activeRecord = $medicalCardFacade->fromSingleModelAsArray($modelAsArray);
        $this->assertInstanceOf(ActiveRecord\MedicalCard\MedicalCardOnly::class, $activeRecord);
        $this->assertEquals($expected, $activeRecord->$getMethodName());
    }

    /** @throws VetmanagerApiGatewayException */
    #[DataProvider('dataProviderWithStringsJson')]
    public function testFromArrayWithStrings(string $json, string $getMethodName, int|string $expected): void
    {
        $modelAsArray = json_decode($json, true);
        $apiGateway = ApiGateway::fromFullUrlAndApiKey("testing", "testing.xxx", "xxx");
        $medicalCardFacade = $apiGateway->getMedicalCard();
        $this->assertInstanceOf(Facade\MedicalCard::class, $medicalCardFacade);
        $activeRecord = $medicalCardFacade->fromSingleModelAsArray($modelAsArray);
        $this->assertInstanceOf(ActiveRecord\MedicalCard\MedicalCardOnly::class, $activeRecord);
        $this->assertEquals($expected, $activeRecord->$getMethodName());
    }

}
