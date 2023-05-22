<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ActiveRecord\Enum\Completeness;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO\AbstractDTO;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayRequestException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;

abstract class AbstractActiveRecord
{
    protected AbstractDTO $originalDto;
    /** Здесь будут данные в виде DTO для отправки в ветменеджер (создание новой записи или редактирование существующей) */
    protected AbstractDTO $userMadeDto;

    /**
     * @param ApiGateway $apiGateway
     * @param array<string,mixed> $originalDataArray Данные в том виде, в котором были получены (массив из раздекодированного JSON)
     * @param Completeness $completenessLevel Enum для указания источника данных. Например, по ID или из запроса Get All придет разное содержимое - тогда, если пользователь будет запрашивать свойство, которое получается при запросе только по ID - сделаю такой запрос и отдам пользователю.
     * @throws VetmanagerApiGatewayException
     */
    protected function __construct(
        protected readonly ApiGateway $apiGateway,
        array                         $originalDataArray,
        protected Completeness        $completenessLevel = Completeness::OnlyBasicDto,
    ) {
        $dtoClassName = static::getApiModel()->getDtoClass();

        if (!is_subclass_of($dtoClassName, AbstractDTO::class)) {
            throw new VetmanagerApiGatewayRequestException();
        }

        $this->originalDto = $dtoClassName::fromApiResponseArray($originalDataArray);
        $this->userMadeDto = $dtoClassName::createEmpty();
    }

//    /** @throws VetmanagerApiGatewayException */ #TODO implement
//    public static function fromArrayAndTypeOfGet(ApiGateway $apiGateway, array $originalDataArray, Source $typeOfGet = Source::OnlyBasicDto): self
//    {
//        return static($apiGateway, $originalDataArray);
//    }

//    /** @throws VetmanagerApiGatewayException */
//    public static function fromSingleObjectArrayAndTypeOfGet(ApiGateway $apiGateway, array $originalDataArray, Source $typeOfSource = Source::OnlyBasicDto): self
//    {
//        return match ($typeOfSource) {
//            Source::GetById => self::fromSingleArrayUsingGetById($apiGateway, $originalDataArray),
//            Source::GetByAllList => self::fromSingleArrayUsingGetAll($apiGateway, $originalDataArray),
//            Source::GetByQuery => self::fromSingleArrayUsingGetByQuery($apiGateway, $originalDataArray),
//            Source::OnlyBasicDto => throw new \Exception('To be implemented')
//        };
//    }

    /** Создание Active Record из АПИ-ответа в виде массива (раздекодированного JSON)
     * @return static[]
     * @throws VetmanagerApiGatewayException
     */
    public static function fromApiResponseArray(ApiGateway $apiGateway, array $apiResponse, Completeness $sourceOfData = Completeness::OnlyBasicDto): array
    {
        $modelKey = static::getApiModel()->getResponseKey();

        if (!isset($apiResponse[$modelKey])) {
            throw new VetmanagerApiGatewayResponseException("Ключ модели не найден в ответе АПИ: '$modelKey'");
        }

        return self::fromMultipleDtosArrays(
            $apiGateway,
            $apiResponse[$modelKey],
            $sourceOfData
        );
    }

    /** @param array $singleDtoAsArray Содержимое: {id: 13, ...}
     * @throws VetmanagerApiGatewayException
     * @psalm-suppress UnsafeInstantiation
     */
    public static function fromSingleDtoArray(
        ApiGateway   $apiGateway,
        array        $singleDtoAsArray,
        Completeness $sourceOfData = Completeness::OnlyBasicDto
    ): static {
        if (empty($singleDtoAsArray)) {
            throw new VetmanagerApiGatewayResponseEmptyException();
        }

        return new static ($apiGateway, $singleDtoAsArray, $sourceOfData);
    }

    /** @param array $singleDtoAsArray Содержимое: {id: 13, ...}
     * @throws VetmanagerApiGatewayException
     */
    public static function fromSingleDtoArrayUsingBasicDto(
        ApiGateway $apiGateway,
        array      $singleDtoAsArray
    ): static {
        return static::fromSingleDtoArray($apiGateway, $singleDtoAsArray, Completeness::OnlyBasicDto);
    }

    /** @param array $listOfMultipleDtosAsArrays Массив объектов. Каждый элемент которого - массив с содержимым объекта: {id: 13, ...}
     * @return static[]
     * @throws VetmanagerApiGatewayException
     */
    public static function fromMultipleDtosArrays(
        ApiGateway   $apiGateway,
        array        $listOfMultipleDtosAsArrays,
        Completeness $sourceOfData = Completeness::OnlyBasicDto
    ): array {
        return array_map(
            fn (array $objectContents): static => static::fromSingleDtoArray($apiGateway, $objectContents, $sourceOfData),
            $listOfMultipleDtosAsArrays
        );
    }

    /** Используется при АПИ-запросах (роуты и имена моделей из тела JSON-ответа на АПИ запрос) */
    abstract public static function getApiModel(): ApiModel;

    public function __set(string $name, mixed $value)
    {
        $this->userMadeDto->$name = $value;
    }

    public function getAsOriginalDataArray(): array
    {
        return $this->originalDto->originalDataArray;
    }

    /** Возвращает в виде DTO в основе текущего объекта Active Record */
    public function getAsDto(): AbstractDTO
    {
        return $this->originalDto;
    }

    /** Получение источника Active Record. Т.е. как был получен, например по прямому АПИ-запросу по ID */
    public function getCompletenessLevel(): Completeness
    {
        return $this->completenessLevel;
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
