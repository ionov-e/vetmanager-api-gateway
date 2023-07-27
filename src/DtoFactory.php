<?php

declare(strict_types=1);

namespace VetmanagerApiGateway;

use ReflectionClass;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use VetmanagerApiGateway\DTO\AbstractModelDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;
use VetmanagerApiGateway\Hydrator\ObjectNormalizer;

/** @template TModelDTO of AbstractModelDTO */
class DtoFactory
{
    public function __construct(
        private readonly Serializer $serializerArrayToObject,
        private readonly Serializer $serializerJsonToObject
    )
    {
    }

    public static function withDefaultSerializers(): self
    {
        return new self (
            new Serializer([new ObjectNormalizer()]),
            new Serializer([new ObjectNormalizer()], [new JsonEncoder()])
        );
    }

    /**
     * @param class-string<AbstractModelDTO> $dtoClassName
     * @throws VetmanagerApiGatewayResponseException
     * @throws VetmanagerApiGatewayInnerException
     */
    public function getFromApiResponseWithSingleModelAsArray(array $apiResponse, string $modelKeyInResponse, string $dtoClassName): AbstractModelDTO
    {
        $modelAsArray = ApiService::getModelsFromApiResponseAsArray($apiResponse, $modelKeyInResponse);
        return $this->getFromSingleModelAsArray($modelAsArray, $dtoClassName);
    }

    /**
     * @param class-string<AbstractModelDTO> $dtoClassName
     * @return AbstractModelDTO[]
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
            fn(array $singleDtoAsArray): AbstractModelDTO => $this->getFromSingleModelAsArray($singleDtoAsArray, $dtoClass),
            $listOfMultipleDtosAsArrays
        );
    }

    /**
     * @param class-string<AbstractModelDTO> $dtoClass
     * @return TModelDTO
     * @throws VetmanagerApiGatewayInnerException
     */
    public function getFromSingleModelAsArray(array $singleDtoAsArray, string $dtoClass): AbstractModelDTO
    {
        if (!is_subclass_of($dtoClass, AbstractModelDTO::class)) {
            throw new VetmanagerApiGatewayInnerException("$dtoClass is not a subclass of " . AbstractModelDTO::class);
        }

        $dto = $this->serializerArrayToObject->denormalize($singleDtoAsArray, $dtoClass);

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
     * @param class-string<AbstractModelDTO> $dtoClass
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