<?php

namespace VetmanagerApiGateway;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use VetmanagerApiGateway\DTO\AbstractModelDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;
use VetmanagerApiGateway\Hydrator\ObjectNormalizer;

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
    public function getAsDtoFromApiResponseAsArray(array $apiResponse, string $modelKey, string $dtoClassName): AbstractModelDTO
    {
        $dtoAsArray = $this->getModelDataFromApiResponseArray($apiResponse, $modelKey);

        return $this->getAsDtoFromSingleModelAsArray($dtoAsArray, $dtoClassName);
    }

    /**
     * @param class-string<AbstractModelDTO> $dtoClassName
     * @throws VetmanagerApiGatewayInnerException
     */
    public function getAsDtoFromSingleModelAsArray(array $dtoAsArray, string $dtoClassName): AbstractModelDTO
    {
        if (!is_subclass_of($dtoClassName, AbstractModelDTO::class)) {
            throw new VetmanagerApiGatewayInnerException("$dtoClassName is not a subclass of " . AbstractModelDTO::class);
        }

        $dto = $this->serializerArrayToObject->denormalize($dtoAsArray, $dtoClassName);

        if (!is_a($dto, $dtoClassName)) {
            throw new VetmanagerApiGatewayInnerException(get_class($this) . " couldn't make DTO: $dtoClassName");
        }

        return $dto;
    }

    /** Создание Active Record из АПИ-ответа в виде массива (раздекодированного JSON)
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getModelDataFromApiResponseArray(array $apiResponse, string $modelKey): array
    {
        if (!isset($apiResponse[$modelKey])) {
            throw new VetmanagerApiGatewayResponseException("Ключ модели не найден в ответе АПИ: '$modelKey'");
        }

        return self::fromMultipleDtosArrays($apiResponse[$modelKey]);
    }

    #TODO getAsDtos method

    /** @param array $listOfMultipleDtosAsArrays Массив объектов. Каждый элемент которого - массив с содержимым объекта: {id: 13, ...}
     * @throws VetmanagerApiGatewayResponseEmptyException
     */
    public static function fromMultipleDtosArrays(array $listOfMultipleDtosAsArrays): array
    {
        return array_map(
            fn(array $objectContents): static => $this->fromSingleDtoArray($objectContents),
            $listOfMultipleDtosAsArrays
        );
    }

    /** @param array $singleDtoAsArray Содержимое: {id: 13, ...}
     * @throws VetmanagerApiGatewayResponseEmptyException
     * @psalm-suppress UnsafeInstantiation
     */
    public function fromSingleDtoArray(array $singleDtoAsArray): static
    {
        if (empty($singleDtoAsArray)) {
            throw new VetmanagerApiGatewayResponseEmptyException();
        }

        return new static ();   #TODO
    }

    private function denormalizeDtoFromArray(array $array, string $className)
    {
        return $this->serializerArrayToObject->denormalize($array, $className);
    }
}