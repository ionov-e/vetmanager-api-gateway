<?php

namespace VetmanagerApiGateway;

use Symfony\Component\Serializer\Serializer;
use VetmanagerApiGateway\DTO\AbstractModelDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayInnerException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;
use VetmanagerApiGateway\Hydrator\ObjectNormalizer;

class DtoFactory
{
    public function __construct(private readonly ApiGateway $apiGateway)
    {
    }

    /**
     * @throws VetmanagerApiGatewayResponseException
     * @throws VetmanagerApiGatewayInnerException
     */
    public function getAsDtoFromApiResponse(array $apiResponse, string $modelKey, string $dtoClassName): AbstractModelDTO
    {
        if (!is_subclass_of($dtoClassName, AbstractModelDTO::class)) {
            throw new VetmanagerApiGatewayInnerException("$dtoClassName is not a subclass of " . AbstractModelDTO::class);
        }

        $dtoAsArray = $this->getModelDataFromApiResponseArray($apiResponse, $modelKey);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $dto = $serializer->denormalize($dtoAsArray, $dtoClassName);

        if (!is_subclass_of($dto, AbstractModelDTO::class)) {
            throw new VetmanagerApiGatewayInnerException("Impossible has happened");
        }

        return $dto;
    }

    #TODO getAsDtos method

    /** Создание Active Record из АПИ-ответа в виде массива (раздекодированного JSON)
     * @throws VetmanagerApiGatewayResponseException
     */
    public function getModelDataFromApiResponseArray(array $apiResponse, string $modelKey): array
    {
//        $modelKey = static::getApiModel()->getResponseKey();
        if (!isset($apiResponse[$modelKey])) {
            throw new VetmanagerApiGatewayResponseException("Ключ модели не найден в ответе АПИ: '$modelKey'");
        }

        return self::fromMultipleDtosArrays($apiResponse[$modelKey]);
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

        return new static ($this->apiGateway);
    }

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
}