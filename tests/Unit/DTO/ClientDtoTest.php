<?php

namespace VetmanagerApiGateway\Unit\DTO;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use VetmanagerApiGateway\DTO\ClientDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;
use VetmanagerApiGateway\Hydrator\ApiBool;

#[CoversClass(ApiBool::class)]
class ClientDtoTest extends TestCase
{
//    public static function dataProviderForStingOrNull(): array
//    {
//        return [
//            [null, null],
//            [true, '1'],
//            [true, 'true'],
//            [true, 'on'],
//            [true, 'yes'],
//            [false, 'off'],
//            [false, '0'],
//            [false, 'false'],
//            [false, 'no'],
//            [false, ''],
//        ];
//    }

    /** @throws VetmanagerApiGatewayResponseException */
//    #[DataProvider('dataProviderForStingOrNull')]
    public function testStringOrNullMethod(): void
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);


        $data = '
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
"last_name": "������",
"first_name": "�������",
"middle_name": "Тестович",
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
}';
        $person = $serializer->deserialize($data, ClientDto::class, 'json');

        $this->assertEquals(
            1,
            $person->getId(),
            'haha'
        );
    }
}
