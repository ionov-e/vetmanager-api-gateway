<?php

namespace VetmanagerApiGateway\Unit\DTO;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use VetmanagerApiGateway\DTO\City\CityOnlyDto;
use VetmanagerApiGateway\DtoFactory;
use VetmanagerApiGateway\DtoNormalizer;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

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
        $denormalizer = DtoFactory::getDefaultSerializerForDenormalization();
        $dto = $denormalizer->deserialize($json, CityOnlyDto::class, 'json');
        $this->assertEquals($expected, $dto->$getMethodName());
    }

    /** @throws VetmanagerApiGatewayResponseException */
    #[DataProvider('dataProviderClientJson')]
    public function testDenormalization(string $json, string $getMethodName, int|string $expected): void
    {
        $array = json_decode($json, true);
        $denormalizer = DtoFactory::getDefaultSerializerForDenormalization();
        $dto = $denormalizer->denormalize($array, CityOnlyDto::class);
        $this->assertEquals($expected, $dto->$getMethodName());
    }

    /** @throws ExceptionInterface */
    #[DataProvider('dataProviderClientJson')]
    public function testNormalizationWithSpecificAttribute(string $json, string $getMethodName, int|string $expected): void
    {
        $array = json_decode($json, true);
        $serializer = DtoNormalizer::getDefaultSerializerForNormalization();
//        $serializer = new Serializer([new ObjectNormalizer()]);
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
//        $serializer = new Serializer([new ObjectNormalizer()]);
//
//        $serializer = new Serializer([new ObjectNormalizer(propertyTypeExtractor: new PhpDocExtractor())]);
//
//
//        $serializer = new Serializer(
//            [new ArrayDenormalizer(), new ObjectNormalizer(propertyTypeExtractor: new PhpDocExtractor())],
//            [new JsonEncoder(defaultContext:  [new PhpDocExtractor()])]
//        );

//        $serializer = DtoFactory::getDefaultSerializer();

//        $serializer = new Serializer(
//            [
//                new ObjectNormalizer(null, null, null, new PhpDocExtractor()),
//                new ArrayDenormalizer(),
//            ],
//            ['json' => new JsonEncoder()]
//        );



//        $serializer = new Serializer(
//            normalizers: [
//                new ArrayDenormalizer(),
//                new ObjectNormalizer(
//                    propertyTypeExtractor: new PropertyInfoExtractor(
////                        typeExtractors: [new PhpDocExtractor(), new ReflectionExtractor()]
//                        typeExtractors: [new PhpDocExtractor()]
//                    ),
//                ),
//            ],
//            encoders: [new JsonEncoder()]
//        );




//        $classMetadataFactory = new ClassMetadataFactory(
//            new AnnotationLoader(
//                new AnnotationReader()
//            )
//        );

//        $serializer = new Serializer(
//            [
//                new ArrayDenormalizer(),
////                new ObjectNormalizer(
////                    $classMetadataFactory,
////                    null,
////                    null,
////                    new PhpDocExtractor()
////                ),
////                new PropertyNormalizer(defaultContext: [PropertyNormalizer::NORMALIZE_PROTECTED]),
//                new PropertyNormalizer(defaultContext: [PropertyNormalizer::NORMALIZE_VISIBILITY]),
//            ],
//            [
//                new JsonEncoder(),
//            ]
//        );

        $denormalizer = DtoFactory::getDefaultSerializerForDenormalization();


        $dto = $denormalizer->denormalize($array, CityOnlyDto::class);

        $this->assertInstanceOf(CityOnlyDto::class, $dto);

        $dto = $dto->setTitle("Test103");
        $dto = $dto->setTypeId(103);

//        $data = $serializer->normalize($dto, null, [AbstractNormalizer::ATTRIBUTES => $dto->getPropertiesSet()]);

        $normalizer = DtoNormalizer::getDefaultSerializerForNormalization();

        $data = $normalizer->normalize($dto, null, [AbstractNormalizer::ATTRIBUTES => $dto->getPropertiesSet()]);

        $this->assertEquals(["title" => "Test103", "type_id" => "103"], $data);
    }
}
