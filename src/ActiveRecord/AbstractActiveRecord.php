<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Enum\Source;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

/**
 * // * @property-read array arrayToSend Массив для отправки Post и Put запросов #TODO Consider whether to have
 */
abstract class AbstractActiveRecord
{
    public readonly AbstractDTO $originalDto;
    /** Здесь будут данные в виде DTO для отправки в ветменеджер (создание новой записи или редактирование существующей) */
    protected AbstractDTO $userMadeDto;
    protected readonly string $apiUnexpectedModelKey;

    /**
     * @param ApiGateway $apiGateway
     * @param array<string, mixed> $originalData Данные в том виде, в котором были получены (массив из раздекодированного JSON)
     * @param class-string $dtoClassName Используемое DTO
     * @param Source $sourceOfData Enum для указания источника данных. Например, по ID или из запроса Get All придет разное содержимое - тогда, если пользователь будет запрашивать свойство, которое получается при запросе только по ID - сделаю такой запрос и отдам пользователю.
     */
    protected function __construct(
        readonly protected ApiGateway $apiGateway,
        public array                  $originalData,
        readonly protected string     $dtoClassName,
        protected Source              $sourceOfData = Source::OnlyBasicDto,
    ) {
        $this->originalDto = new $dtoClassName($originalData);
        $this->userMadeDto = new $dtoClassName([]);
    }

//    protected function __construct(
//        readonly protected ApiGateway $apiGateway,
//        public array                  $originalData,
//        readonly protected string     $dtoClassName,
//        readonly protected string     $apiRoute,
//        protected Source              $sourceOfData = Source::OnlyBasicDto,
//        string                        $apiUnexpectedModelKey = '',
//    ) {
//        $this->apiUnexpectedModelKey = $apiUnexpectedModelKey ?: $apiRoute;
//        $this->originalDto = new $dtoClassName($originalData);
//        $this->userMadeDto = new $dtoClassName([]);
//    }

//    /** @throws VetmanagerApiGatewayException */
//    public static function fromArrayAndTypeOfGet(ApiGateway $apiGateway, array $originalData, Source $typeOfGet = Source::OnlyBasicDto): self
//    {
//        return static($apiGateway, $originalData);
//    }

    /** Создание Active Record из АПИ-ответа в виде массива (раздекодированного JSON)
     * @return static[]
     * @throws VetmanagerApiGatewayResponseException
     */
    public static function fromApiResponseArray(ApiGateway $apiGateway, array $apiResponse, Source $sourceOfData = Source::OnlyBasicDto): array
    {
        $modelKey = static::getApiModel()->getApiModelResponseKey();

        if (!isset($apiResponse[$modelKey])) {
            /** @psalm-suppress PossiblyInvalidCast Бредовое предупреждение */
            throw new VetmanagerApiGatewayResponseException("Ключ модели не найден в ответе АПИ: '$modelKey'");
        }

        return self::fromMultipleObjectsContents(
            $apiGateway,
            $apiResponse[$modelKey],
            $sourceOfData
        );
    }

    /** @param array<string, mixed> $objectContents Содержимое: {id: 13, ...}
     * @throws VetmanagerApiGatewayResponseEmptyException
     * @psalm-suppress UnsafeInstantiation
     */
    public static function fromSingleObjectContents(
        ApiGateway $apiGateway,
        array      $objectContents,
        Source     $sourceOfData = Source::OnlyBasicDto
    ): static {
        if (empty($objectContents)) {
            throw new VetmanagerApiGatewayResponseEmptyException();
        }

        return new static ($apiGateway, $objectContents, $sourceOfData);
    }

    /**
     * @param array $objects Массив объектов. Каждый элемент которого - массив с содержимым объекта: {id: 13, ...}
     * @return static[]
     * @throws VetmanagerApiGatewayResponseEmptyException
     */
    public static function fromMultipleObjectsContents(
        ApiGateway $apiGateway,
        array      $objects,
        Source     $sourceOfData = Source::OnlyBasicDto
    ): array {
        return array_map(
            fn (array $objectContents): static => static::fromSingleObjectContents($apiGateway, $objectContents, $sourceOfData),
            $objects
        );
    }

//    /** Используется при АПИ-запросах (роуты и имена моделей из тела JSON-ответа на АПИ запрос) */
//    abstract public static function getApiModel(): ApiRoute;

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
