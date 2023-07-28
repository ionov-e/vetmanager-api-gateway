<?php

namespace VetmanagerApiGateway\Unit\DTO;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Serializer;
use VetmanagerApiGateway\DTO\City\CityOnlyDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;
use VetmanagerApiGateway\Hydrator\ObjectNormalizer;

#[CoversClass(CityOnlyDto::class)]
class CityDtoTest extends TestCase
{
    public static function dataProviderClientJson(): array
    {
        return [
            [
                /** @lang JSON */
                <<<'EOF'
{
    "id": "255",
    "title": "city_001",
    "type_id": "1"
}
EOF
                , "getId", 255]
        ];
    }

    /** @throws VetmanagerApiGatewayResponseException */
    #[DataProvider('dataProviderClientJson')]
    public function testDeserialization(string $json, string $getMethodName, int|string $expected): void
    {
        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        $dto = $serializer->deserialize($json, CityOnlyDto::class, 'json');
        $this->assertEquals($expected, $dto->$getMethodName());
    }

    /** @throws VetmanagerApiGatewayResponseException */
    #[DataProvider('dataProviderClientJson')]
    public function testDenormalization(string $json, string $getMethodName, int|string $expected): void
    {
        $array = json_decode($json, true);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $dto = $serializer->denormalize($array, CityOnlyDto::class);
        $this->assertEquals($expected, $dto->$getMethodName());
    }

    /** @throws ExceptionInterface */
    #[DataProvider('dataProviderClientJson')]
    public function testNormalizationWithSpecificAttribute(string $json, string $getMethodName, int|string $expected): void
    {
        $array = json_decode($json, true);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $dto = $serializer->denormalize($array, CityOnlyDto::class);
        $data = $serializer->normalize($dto, null, [AbstractNormalizer::ATTRIBUTES => ['id']]);
        $this->assertEquals($expected, $data['id']);
    }

    /** @throws VetmanagerApiGatewayInnerException
     * @throws ExceptionInterface
     */
    #[DataProvider('dataProviderClientJson')]
    public function testNormalizationWithSpecificAttributeAfterSetters(string $json, string $getMethodName, int|string $expected): void
    {
        $array = json_decode($json, true);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $dto = $serializer->denormalize($array, CityOnlyDto::class);

        $this->assertInstanceOf(CityOnlyDto::class, $dto);

        $dto = $dto->setTitle("Test103");
        $dto = $dto->setTypeId(103);

        $data = $serializer->normalize($dto, null, [AbstractNormalizer::ATTRIBUTES => $dto->getPropertiesSet()]);

        $this->assertEquals(["title" => "Test103", "type_id" => "103"], $data);
    }
}
