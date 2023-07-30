<?php

namespace VetmanagerApiGateway\Unit\Facade;

use GuzzleHttp\Client;
use Otis22\VetmanagerRestApi\Headers\Auth\ApiKey;
use Otis22\VetmanagerRestApi\Headers\Auth\ByApiKey;
use Otis22\VetmanagerRestApi\Headers\WithAuthAndParams;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use VetmanagerApiGateway\ActiveRecord\Breed\BreedOnly;
use VetmanagerApiGateway\ActiveRecord\PetType\PetTypePlusBreeds;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\ApiService;
use VetmanagerApiGateway\DtoFactory;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

class PetTypeTest extends TestCase
{


    public static function dataProviderJson(): array
    {
        return [[
            /** @lang JSON */
            <<<'EOF'
{
"id": "1",
"title": "Кошки",
"picture": "cat",
"type": "cat",
"breeds": [
    {
        "id": "1",
        "title": "Абиссинская ",
        "pet_type_id": "1"
    },
    {
        "id": "2",
        "title": "Австралийская дымчатая",
        "pet_type_id": "1"
    },
    {
        "id": "3",
        "title": "Азиатская кошка",
        "pet_type_id": "1"
    },
    {
        "id": "4",
        "title": "Азиатская тикинг-табби",
        "pet_type_id": "1"
    }
]
}
EOF
        ]];
    }

    /** @throws VetmanagerApiGatewayException */
    #[DataProvider('dataProviderJson')]
    public function testSpecificARFromSingleModelAsArray(string $json)
    {
        $modelAsArray = json_decode($json, true);
        $apiService = new ApiService(new Client(), new WithAuthAndParams(new ByApiKey(new ApiKey("testing")), ['X-REST-TIME-ZONE' => '+03:00']));
        $activeRecordFactory = new ActiveRecordFactory(
            $apiService,
            DtoFactory::withDefaultSerializer()
        );
        $activeRecord = $activeRecordFactory->getFromSingleModelAsArray($modelAsArray, PetTypePlusBreeds::class);
        $breedsActiveRecords = $activeRecord->getBreeds();
        $breedActiveRecord = $breedsActiveRecords[0];
        $this->assertInstanceOf(BreedOnly::class, $breedActiveRecord);
        $this->assertEquals("Абиссинская ", $breedActiveRecord->getTitle());
    }
}
