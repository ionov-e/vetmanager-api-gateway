<?php

namespace VetmanagerApiGateway\Unit\Facade;

use GuzzleHttp\Client;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\ApiConnection;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DtoFactory;
use VetmanagerApiGateway\DtoNormalizer;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade\CityType;

#[CoversClass(CityType::class)]
class CityTypeTest extends TestCase
{

    public static function dataProviderModelsAsArraysInJson(): array
    {
        return [[
            /** @lang JSON */
            <<<'EOF'
[
        {"id": 2,"title": "Деревня"},
        {"id": 3,"title": "Поселок"},
        {"id": 4,"title": "ПГТ"},
        {"id": 5,"title": "Село"},
        {"id": 7,"title": "Станица"},
        {"id": 8,"title": "Станция"},
        {"id": 9,"title": "Хутор"},
        {"id": 10,"title": "Агрогородок"},
        {"id": 11,"title": "СНТ"}
]
EOF
        ]];
    }

    /** @throws VetmanagerApiGatewayException */
    #[DataProvider('dataProviderModelsAsArraysInJson')]
    public function testCreationFromModelsAsArrays(string $json): void
    {
        $modelsAsArrays = json_decode($json, true);
        $apiService = new ApiConnection(new Client(), "test.test");
        $activeRecordFactory = new ActiveRecordFactory(
            $apiService,
            DtoFactory::withDefaultSerializer(),
            DtoNormalizer::withDefaultSerializer()
        );
        $activeRecords = $activeRecordFactory->getFromMultipleModelsAsArray($modelsAsArrays, \VetmanagerApiGateway\ActiveRecord\CityType\CityType::class);
        $this->assertContainsOnlyInstancesOf(\VetmanagerApiGateway\ActiveRecord\CityType\CityType::class, $activeRecords);
        $singleAR = $activeRecords[0];
        $this->assertInstanceOf(\VetmanagerApiGateway\ActiveRecord\CityType\CityType::class, $singleAR);
        $this->assertEquals("Деревня", $singleAR->getTitle());
    }

    public static function dataProviderModelsAsArray(): array
    {
        return [[
            [
                ["id" => 2, "title" => "Деревня"],
                ["id" => 3, "title" => "Поселок"],
                ["id" => 4, "title" => "ПГТ"],
                ["id" => 5, "title" => "Село"],
                ["id" => 7, "title" => "Станица"],
                ["id" => 8, "title" => "Станция"],
                ["id" => 9, "title" => "Хутор"],
                ["id" => 10, "title" => "Агрогородок"],
                ["id" => 11, "title" => "СНТ"]
            ]
        ]];
    }

    /** @throws VetmanagerApiGatewayException */
    #[DataProvider('dataProviderModelsAsArray')]
    public function testCreationFromModelsAsArray(array $modelsAsArray): void
    {
        $apiGateway = ApiGateway::fromFullUrlAndApiKey("testing", "testing.xxx", "xxx");
        $activeRecords = $apiGateway->getCityType()->fromMultipleModelsAsArrays($modelsAsArray);
        $singleAR = $activeRecords[0];
        $this->assertInstanceOf(\VetmanagerApiGateway\ActiveRecord\CityType\CityType::class, $singleAR);
        $this->assertEquals("Деревня", $singleAR->getTitle());
    }
}
