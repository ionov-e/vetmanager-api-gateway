<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO\DTO;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseEmptyException;

abstract class AbstractDTO
{
    /** @throws VetmanagerApiGatewayResponseEmptyException */
    protected function __construct(
        protected ApiGateway     $apiGateway,
        readonly protected array $originalData
    ) {
        if (empty($this->originalData)) {
            throw new VetmanagerApiGatewayResponseEmptyException();
        }
    }

    /** @param array{string: string} $objectContents Содержимое: {id: 13, ...}
     * @throws VetmanagerApiGatewayResponseEmptyException
     */
    public static function fromSingleObjectContents(ApiGateway $apiGateway, array $objectContents): static
    {
        return new static ($apiGateway, $objectContents);
    }

    /** @param array<int, array{string: string}> $objects Массив объектов. Каждый элемент которого - массив с содержимым объекта: {id: 13, ...}
     * @return static[]
     * @throws VetmanagerApiGatewayResponseEmptyException
     */
    public static function fromMultipleObjectsContents(ApiGateway $apiGateway, array $objects): array
    {
        return array_map(
            fn (array $objectContents): static => static::fromSingleObjectContents($apiGateway, $objectContents),
            $objects
        );
    }

    /** Возвращение данных в том же виде, в котором и были получены (массив из раздекодированного JSON) */
    public function getOriginalObjectData(): array
    {
        return $this->originalData;
    }
}
