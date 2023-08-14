<?php

declare(strict_types=1);

namespace VetmanagerApiGateway;

use GuzzleHttp\Client;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

class ApiRequest
{
    public function __construct(private readonly Client $guzzleClient)
    {
    }

    /** @throws VetmanagerApiGatewayResponseException */
    public static function getDataContentsFromApiResponseAsArray(array $apiResponseAsArray): array
    {
        if (!isset($apiResponseAsArray['data'])) {
            throw new VetmanagerApiGatewayResponseException(
                "В ответе от АПИ: отсутствует элемент 'data': " . json_encode($apiResponseAsArray, JSON_UNESCAPED_UNICODE)
            );
        }

        if (!is_array($apiResponseAsArray['data'])) {
            throw new VetmanagerApiGatewayResponseException(
                "В ответе от АПИ: элемент 'data' не является массивом: " . json_encode($apiResponseAsArray, JSON_UNESCAPED_UNICODE)
            );
        }

        return $apiResponseAsArray['data'];
    }

    /** Вернет либо массив с моделью, либо массив с такими моделями в виде массивов
     * @throws VetmanagerApiGatewayResponseException
     */
    public static function getModelsFromApiResponseAsArray(array $apiResponseAsArray, string $modelKeyInResponse): array
    {
        $dataContentsFromApiResponse = self::getDataContentsFromApiResponseAsArray($apiResponseAsArray);
        return self::getModelsFromApiResponseDataElement($dataContentsFromApiResponse, $modelKeyInResponse);
    }

    /** @throws VetmanagerApiGatewayResponseException */
    public static function getModelsFromApiResponseDataElement(array $apiDataContents, string $modelKeyInResponse): array
    {
        if (!isset($apiDataContents[$modelKeyInResponse])) {
            throw new VetmanagerApiGatewayResponseException(
                "Не найден ключ модели '$modelKeyInResponse' в JSON ответе от АПИ: " . json_encode($apiDataContents, JSON_UNESCAPED_UNICODE)
            );
        }

        return $apiDataContents[$modelKeyInResponse];
    }
}