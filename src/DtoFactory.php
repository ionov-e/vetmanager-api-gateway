<?php

declare(strict_types=1);

namespace VetmanagerApiGateway;

use ReflectionClass;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

/** @template TModelDTO of AbstractDTO */
class DtoFactory
{
    public function __construct(private readonly Serializer $serializer)
    {
    }

    public static function withDefaultSerializer(): self
    {
        return new self (self::getDefaultSerializerForDenormalization());
    }

    /** Используется при denormalize методе. Может использоваться при сериализации */
    public static function getDefaultSerializerForDenormalization(): Serializer
    {
        return new Serializer(
            [
                new ArrayDenormalizer(),
                new ObjectNormalizer(propertyTypeExtractor: new PhpDocExtractor())
            ],
            [new JsonEncoder()]
        );
    }

    /**
     * @param class-string<AbstractDTO> $dtoClassName
     * @throws VetmanagerApiGatewayResponseException
     * @throws VetmanagerApiGatewayInnerException
     */
    public function getFromApiResponseWithSingleModelAsArray(array $apiResponse, string $modelKeyInResponse, string $dtoClassName): AbstractDTO
    {
        $modelAsArray = ApiService::getModelsFromApiResponseAsArray($apiResponse, $modelKeyInResponse);
        return $this->getFromSingleModelAsArray($modelAsArray, $dtoClassName);
    }

    /**
     * @param class-string<AbstractDTO> $dtoClassName
     * @return AbstractDTO[]
     * @throws VetmanagerApiGatewayResponseException
     * @throws VetmanagerApiGatewayInnerException
     */
    public function getFromApiResponseWithMultipleModelsArray(array $apiResponse, string $modelKeyInResponse, string $dtoClassName): array
    {
        $modelsAsArrays = ApiService::getModelsFromApiResponseAsArray($apiResponse, $modelKeyInResponse);
        return $this->getFromModelsAsArrays($modelsAsArrays, $dtoClassName);
    }

    /**
     * @param array $listOfMultipleDtosAsArrays Массив объектов. Каждый элемент которого - массив с содержимым объекта: {id: 13, ...}
     * @param class-string<TModelDTO> $dtoClass
     * @return TModelDTO[]
     * @throws VetmanagerApiGatewayInnerException
     */
    public function getFromModelsAsArrays(array $listOfMultipleDtosAsArrays, string $dtoClass): array
    {
        return array_map(
            fn(array $singleDtoAsArray): AbstractDTO => $this->getFromSingleModelAsArray($singleDtoAsArray, $dtoClass),
            $listOfMultipleDtosAsArrays
        );
    }

    /**
     * @param class-string<AbstractDTO> $dtoClass
     * @psalm-return TModelDTO
     * @throws VetmanagerApiGatewayInnerException
     */
    public function getFromSingleModelAsArray(array $singleDtoAsArray, string $dtoClass): AbstractDTO
    {
        if (!is_subclass_of($dtoClass, AbstractDTO::class)) {
            throw new VetmanagerApiGatewayInnerException("$dtoClass is not a subclass of " . AbstractDTO::class);
        }

        $dto = $this->serializer->denormalize($singleDtoAsArray, $dtoClass);

        if (!is_a($dto, $dtoClass)) {
            throw new VetmanagerApiGatewayInnerException(get_class($this) . " couldn't make DTO: $dtoClass");
        }

        return $dto;
    }

    /**
     * @param class-string<TModelDTO> $dtoClass
     * @return TModelDTO
     * @throws VetmanagerApiGatewayInnerException
     */
    public function getEmpty(string $dtoClass)
    {
        $numberOfParameterInConstructor = $this->getNumberOfParametersInConstructor($dtoClass);
        return new $dtoClass(...array_fill(0, $numberOfParameterInConstructor, null));
    }

    /**
     * @param class-string<AbstractDTO> $dtoClass
     * @throws VetmanagerApiGatewayInnerException
     */
    private function getNumberOfParametersInConstructor(string $dtoClass): int
    {
        try {
            $reflectionClass = new ReflectionClass($dtoClass);
            $constructor = $reflectionClass->getConstructor();

            if ($constructor === null) {
                throw new VetmanagerApiGatewayInnerException("In class: $dtoClass found no parameters in constructor");
            }

            return $constructor->getNumberOfParameters();
        } catch (\ReflectionException) {
            throw new VetmanagerApiGatewayInnerException("Couldn't make reflection of: $dtoClass");
        }
    }
}