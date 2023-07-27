<?php

namespace VetmanagerApiGateway;

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
    public function getAsDtoFromApiResponseWithSingleModelAsArray(array $apiResponse, string $modelKeyInResponse, string $dtoClassName): AbstractModelDTO
    {
        $modelAsArray = ApiService::getModelsFromApiResponseAsArray($apiResponse, $modelKeyInResponse);
        return $this->getAsDtoFromSingleModelAsArray($modelAsArray, $dtoClassName);
    }

    /**
     * @param class-string<AbstractModelDTO> $dtoClassName
     * @return AbstractModelDTO[]
     * @throws VetmanagerApiGatewayResponseException
     * @throws VetmanagerApiGatewayInnerException
     */
    public function getAsDtosFromApiResponseWithMultipleModelsArray(array $apiResponse, string $modelKeyInResponse, string $dtoClassName): array
    {
        $modelsAsArrays = ApiService::getModelsFromApiResponseAsArray($apiResponse, $modelKeyInResponse);
        return $this->getAsMultipleDtosFromModelsAsArrays($modelsAsArrays, $dtoClassName);
    }

    /**
     * @param array $listOfMultipleDtosAsArrays Массив объектов. Каждый элемент которого - массив с содержимым объекта: {id: 13, ...}
     * @param class-string<TModelDTO> $dtoClass
     * @return TModelDTO[]
     * @throws VetmanagerApiGatewayInnerException
     */
    public function getAsMultipleDtosFromModelsAsArrays(array $listOfMultipleDtosAsArrays, string $dtoClass): array
    {
        return array_map(
            fn(array $singleDtoAsArray): AbstractModelDTO => $this->getAsDtoFromSingleModelAsArray($singleDtoAsArray, $dtoClass),
            $listOfMultipleDtosAsArrays
        );
    }
    
    /**
     * @param class-string<AbstractModelDTO> $dtoClass
     * @return TModelDTO
     * @throws VetmanagerApiGatewayInnerException
     */
    public function getAsDtoFromSingleModelAsArray(array $singleDtoAsArray, string $dtoClass): AbstractModelDTO
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
}