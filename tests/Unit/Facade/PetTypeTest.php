<?php

namespace VetmanagerApiGateway\Unit\Facade;

use GuzzleHttp\Client;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use VetmanagerApiGateway\ActiveRecord\Breed\BreedOnly;
use VetmanagerApiGateway\ActiveRecord\PetType\PetTypePlusBreeds;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\ApiConnection;
use VetmanagerApiGateway\DtoFactory;
use VetmanagerApiGateway\DtoNormalizer;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade\PetType;

#[CoversClass(PetType::class)]
class PetTypeTest extends TestCase
{
    public static function dataProviderJson(): array
    {
        return [[
            /** @lang JSON */
            <<<'EOF'
{
"id": 1,
"title": "Кошки",
"picture": "cat",
"type": "cat",
"breeds": [
    {
        "id": 1,
        "title": "Абиссинская ",
        "pet_type_id": 1
    },
    {
        "id": 2,
        "title": "Австралийская дымчатая",
        "pet_type_id": 1
    },
    {
        "id": 3,
        "title": "Азиатская кошка",
        "pet_type_id": 1
    },
    {
        "id": 4,
        "title": "Азиатская тикинг-табби",
        "pet_type_id": 1
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
        $apiService = new ApiConnection(new Client(), "test.test");
        $activeRecordFactory = new ActiveRecordFactory(
            $apiService,
            DtoFactory::withDefaultSerializer(),
            DtoNormalizer::withDefaultSerializer()
        );
        $activeRecord = $activeRecordFactory->getFromSingleModelAsArray($modelAsArray, PetTypePlusBreeds::class);
        $breedsActiveRecords = $activeRecord->getBreeds();
        $breedActiveRecord = $breedsActiveRecords[0];
        $this->assertInstanceOf(BreedOnly::class, $breedActiveRecord);
        $this->assertEquals("Абиссинская ", $breedActiveRecord->getTitle());
    }
}
