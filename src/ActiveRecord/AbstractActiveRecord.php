<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Enum\ApiRoute;
use VetmanagerApiGateway\ActiveRecord\Enum\Source;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

/**
 * @property-read array arrayToSend Массив для отправки Post и Put запросов #TODO Consider whether to have
 * @property-write AbstractDTO userMadeDto Здесь будут данные в виде DTO для отправки в ветменеджер (создание новой записи или редактирование существующей)
 */
abstract class AbstractActiveRecord
{
    /**
     * @param ApiGateway $apiGateway
     * @param array<string, mixed> $originalData Данные в том виде, в котором были получены (массив из раздекодированного JSON)
     * @param Source $sourceOfData Enum для указания источника данных. Например, по ID или из запроса Get All придет разное содержимое - тогда, если пользователь будет запрашивать свойство, которое получается при запросе только по ID - сделаю такой запрос и отдам пользователю.
     */
    protected function __construct(
        readonly protected ApiGateway                   $apiGateway,
        readonly protected array                        $originalData,
        protected Source $sourceOfData
    ) {
    }

    /** Создание Active Record из АПИ-ответа в виде массива (раздекодированного JSON)
     * @return static[]
     * @throws VetmanagerApiGatewayResponseException
     */
    public static function fromResponse(ApiGateway $apiGateway, array $apiResponse): array
    {
        $modelKey = static::getApiModel()->getApiModelResponseKey();

        if (!isset($apiResponse[$modelKey])) {
            /** @psalm-suppress PossiblyInvalidCast Бредовое предупреждение */
            throw new VetmanagerApiGatewayResponseException("Ключ модели не найден в ответе АПИ: '$modelKey'");
        }

        return self::fromMultipleObjectsContents(
            $apiGateway,
            $apiResponse[$modelKey]
        );
    }

    /** @param array<string, mixed> $objectContents Содержимое: {id: 13, ...}
     * @throws VetmanagerApiGatewayResponseEmptyException
     * @psalm-suppress UnsafeInstantiation
     */
    public static function fromSingleObjectContents(ApiGateway $apiGateway, array $objectContents): static
    {
        if (empty($objectContents)) {
            throw new VetmanagerApiGatewayResponseEmptyException();
        }

        return new static ($apiGateway, $objectContents);
    }

    /**
     * @param array $objects Массив объектов. Каждый элемент которого - массив с содержимым объекта: {id: 13, ...}
     *
     * @return static[]
     *
     * @throws VetmanagerApiGatewayResponseEmptyException
     */
    public static function fromMultipleObjectsContents(ApiGateway $apiGateway, array $objects): array
    {
        return array_map(
            fn (array $objectContents): static => static::fromSingleObjectContents($apiGateway, $objectContents),
            $objects
        );
    }

    /** Используется при АПИ-запросах (роуты и имена моделей из тела JSON-ответа на АПИ запрос) */
    abstract public static function getApiModel(): ApiRoute;

    public function __set($name, $value)
    {
        $this->userMadeDto->$name = $value;
    }

    public function getAsArrayOriginalObject(): array  #TODO Probably not needing it
    {
        return $this->originalData;
    }

    /** Получение  */
    public function getSourceOfData(): string
    {
        return $this->sourceOfData->name;
    }

    /** @throws VetmanagerApiGatewayRequestException */
    public function getAsArrayForPostRequest(): array
    {
        return $this->userMadeDto->getAsArrayForPostRequest();
    }

    /** @throws VetmanagerApiGatewayRequestException */
    public function getAsArrayForPutRequest(): array
    {
        return $this->userMadeDto->getAsArrayForPutRequest();
    }
}
