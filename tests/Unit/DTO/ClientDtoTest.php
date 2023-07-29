<?php

namespace VetmanagerApiGateway\Unit\DTO;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Serializer;
use VetmanagerApiGateway\DTO\Client\ClientOnlyDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;
use VetmanagerApiGateway\Hydrator\ObjectNormalizer;

#[CoversClass(ClientOnlyDto::class)]
class ClientDtoTest extends TestCase
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
"phone_prefix": "38"
}
EOF
                , "getId", 1]
        ];
    }

    /** @throws VetmanagerApiGatewayResponseException */
    #[DataProvider('dataProviderClientJson')]
    public function testStringOrNullMethod(string $json, string $getMethodName, int|string $expected): void
    {
        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        $dto = $serializer->deserialize($json, ClientOnlyDto::class, 'json');
        $this->assertEquals($expected, $dto->$getMethodName());
    }

    /** @throws VetmanagerApiGatewayInnerException
     * @throws ExceptionInterface
     */
    #[DataProvider('dataProviderClientJson')]
    public function testNormalizationWithSpecificAttributeAfterSetters(string $json, string $getMethodName, int|string $expected): void
    {
        $array = json_decode($json, true);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $dto = $serializer->denormalize($array, ClientOnlyDto::class);

        $this->assertInstanceOf(ClientOnlyDto::class, $dto);

        $dto = $dto->setAddress("Address 112");
        $dto = $dto->setCityId(103);

        $data = $serializer->normalize($dto, null, [AbstractNormalizer::ATTRIBUTES => $dto->getPropertiesSet()]);

        $this->assertEquals(["address" => "Address 112", "city_id" => "103"], $data);
    }
}
