<?php

namespace VetmanagerApiGateway\Unit\DTO;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use VetmanagerApiGateway\DTO\Client\ClientPlusTypeAndCityDto;
use VetmanagerApiGateway\DtoFactory;
use VetmanagerApiGateway\DtoNormalizer;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;


#[CoversClass(ClientPlusTypeAndCityDto::class)]
class ClientPlusTypeAndCityDtoTest extends TestCase
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

    /** @throws VetmanagerApiGatewayResponseException */
    #[DataProvider('dataProviderClientJson')]
    public function testStringOrNullMethod(string $json, string $getMethodName, int|string $expected): void
    {
        $denormalizer = DtoFactory::getDefaultSerializerForDenormalization();
        $dto = $denormalizer->deserialize($json, ClientPlusTypeAndCityDto::class, 'json');
        $this->assertInstanceOf(ClientPlusTypeAndCityDto::class, $dto);
        $this->assertEquals($expected, $dto->$getMethodName());
        $this->assertEquals("Временный", $dto->getClientTypeDto()->getTitle());
    }

    /** @throws VetmanagerApiGatewayInnerException|ExceptionInterface */
    #[DataProvider('dataProviderClientJson')]
    public function testNormalizationWithSpecificAttributeAfterSetters(string $json, string $getMethodName, int|string $expected): void
    {
        $array = json_decode($json, true);
        $denormalizer = DtoFactory::getDefaultSerializerForDenormalization();
        $dto = $denormalizer->denormalize($array, ClientPlusTypeAndCityDto::class);

        $this->assertInstanceOf(ClientPlusTypeAndCityDto::class, $dto);

        $dto = $dto->setAddress("Address 112");
        $dto = $dto->setCityId(103);

        $normalizer = DtoNormalizer::getDefaultSerializerForNormalization();
        $data = $normalizer->normalize($dto, null, [AbstractNormalizer::ATTRIBUTES => $dto->getPropertiesSet()]);

        $this->assertEquals(["address" => "Address 112", "city_id" => "103"], $data);
    }
}
