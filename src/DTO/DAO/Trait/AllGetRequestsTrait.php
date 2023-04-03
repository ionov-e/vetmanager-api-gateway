<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\DAO\Trait;

use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO\DAO\Interface\AllGetRequestsInterface;
use VetmanagerApiGateway\DTO\Enum\ApiRoute;

/**
 * Реализация интерфейса {@see AllGetRequestsInterface}. Используется только в дочерних классах DTO {@see AbstractDTO} этой библиотеки.
 * Не все DTO имеют прямой АПИ доступ. Методы перечисленные в этом трейте могут быть отнесены только к DTO с прямым доступом
 *
 * @property-read ApiGateway $apiGateway {@see AbstractDTO::$apiGateway}
 * @property array $originalData {@see AbstractDTO::$originalData}
 * @method static ApiRoute getApiModel(ApiGateway $apiGateway, array $array)
 * @method static self fromSingleObjectContents(ApiGateway $apiGateway, array $array)
 * @method static self fromJson(ApiGateway $apiGateway, string $json)
 *
 * PhpDoc пока не поддерживает ссылки в описаниях методов, поэтому приведены ниже:
 * {@see BasicDAOInterface::getApiModel()} {@see AbstractDTO::fromSingleObjectContents()}
 */
trait AllGetRequestsTrait
{
    use RequestGetAllTrait, RequestGetByIdTrait, RequestGetByQuery;
}
