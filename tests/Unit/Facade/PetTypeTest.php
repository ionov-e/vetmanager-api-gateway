<?php

namespace VetmanagerApiGateway\Unit\Facade;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use VetmanagerApiGateway\ActiveRecord\Breed\BreedOnly;
use VetmanagerApiGateway\ActiveRecord\PetType\PetTypePlusBreeds;
use VetmanagerApiGateway\ApiGateway;
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
    public function testSpecificARFromSingleModelAsArray(string $json)    #TODO return
    {
        $modelAsArray = json_decode($json, true);
        $apiGateway = ApiGateway::fromFullUrlAndApiKey("testing", "testing.xxx", "xxx");
        $activeRecord = $apiGateway->getPetType()->specificARFromSingleModelAsArray($modelAsArray, PetTypePlusBreeds::class);
        $breedsActiveRecords = $activeRecord->getBreeds();
        $breedActiveRecord = $breedsActiveRecords[0];
        $this->assertInstanceOf(BreedOnly::class, $breedActiveRecord);
        $this->assertEquals("Абиссинская ", $breedActiveRecord->getTitle());
    }
}
