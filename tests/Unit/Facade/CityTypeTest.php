<?php

namespace VetmanagerApiGateway\Unit\Facade;

use GuzzleHttp\Client;
use Otis22\VetmanagerRestApi\Headers\Auth\ApiKey;
use Otis22\VetmanagerRestApi\Headers\Auth\ByApiKey;
use Otis22\VetmanagerRestApi\Headers\WithAuthAndParams;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\ApiService;
use VetmanagerApiGateway\DtoFactory;
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
        $apiService = new ApiService(new Client(), new WithAuthAndParams(new ByApiKey(new ApiKey("testing")), ['X-REST-TIME-ZONE' => '+03:00']));
        $activeRecordFactory = new ActiveRecordFactory(
            $apiService,
            DtoFactory::withDefaultSerializer()
        );
        $activeRecords = $activeRecordFactory->getFromApiResponseWithMultipleModelsAsArray($apiResponseAsArray, \VetmanagerApiGateway\ActiveRecord\CityType\CityType::class);
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
        $activeRecords = $apiGateway->getCityType()->fromMultipleModelsAsArrays($modelsAsArray);
        $singleAR = $activeRecords[0];
        $this->assertInstanceOf(\VetmanagerApiGateway\ActiveRecord\CityType\CityType::class, $singleAR);
        $this->assertEquals("Деревня", $singleAR->getTitle());
    }
}
