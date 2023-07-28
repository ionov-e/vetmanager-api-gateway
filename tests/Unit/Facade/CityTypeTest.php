<?php

namespace VetmanagerApiGateway\Unit\Facade;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class CityTypeTest extends TestCase
{

    public static function dataProviderFullResponseAsJson(): array
    {
        return [[
            /** @lang JSON */
            <<<'EOF'
{
"success": true,
"message": "Records Retrieved Successfully",
"data": {
    "totalCount": "9",
    "cityType": [
        {"id": "2","title": "Деревня"},
        {"id": "3","title": "Поселок"},
        {"id": "4","title": "ПГТ"},
        {"id": "5","title": "Село"},
        {"id": "7","title": "Станица"},
        {"id": "8","title": "Станция"},
        {"id": "9","title": "Хутор"},
        {"id": "10","title": "Агрогородок"},
        {"id": "11","title": "СНТ"}
        ]
    }
}
EOF
        ]];
    }

    /** @throws VetmanagerApiGatewayException */
    #[DataProvider('dataProviderFullResponseAsJson')]
    public function testCreationFromResponseAsArray(string $json): void
    {
        $apiResponseAsArray = json_decode($json, true);
        $apiGateway = ApiGateway::fromFullUrlAndApiKey("testing", "testing.xxx", "xxx");
        $activeRecords = $apiGateway->getCityType()->fromApiResponseWithMultipleModelsAsArray($apiResponseAsArray);
        $this->assertContainsOnlyInstancesOf(\VetmanagerApiGateway\ActiveRecord\CityType\CityType::class, $activeRecords);
        $singleAR = $activeRecords[0];
        $this->assertInstanceOf(\VetmanagerApiGateway\ActiveRecord\CityType\CityType::class, $singleAR);
        $this->assertEquals("Деревня", $singleAR->getTitle());
    }

    public static function dataProviderModelsAsArray(): array
    {
        return [[
            [
                ["id" => "2", "title" => "Деревня"],
                ["id" => "3", "title" => "Поселок"],
                ["id" => "4", "title" => "ПГТ"],
                ["id" => "5", "title" => "Село"],
                ["id" => "7", "title" => "Станица"],
                ["id" => "8", "title" => "Станция"],
                ["id" => "9", "title" => "Хутор"],
                ["id" => "10", "title" => "Агрогородок"],
                ["id" => "11", "title" => "СНТ"]
            ]
        ]];
    }

    /** @throws VetmanagerApiGatewayException */
    #[DataProvider('dataProviderModelsAsArray')]
    public function testCreationFromModelsAsArray(array $modelsAsArray): void
    {
        $apiGateway = ApiGateway::fromFullUrlAndApiKey("testing", "testing.xxx", "xxx");
        $activeRecords = $apiGateway->getCityType()->fromMultipleModelsAsArray($modelsAsArray);
        $singleAR = $activeRecords[0];
        $this->assertInstanceOf(\VetmanagerApiGateway\ActiveRecord\CityType\CityType::class, $singleAR);
        $this->assertEquals("Деревня", $singleAR->getTitle());
    }
}
