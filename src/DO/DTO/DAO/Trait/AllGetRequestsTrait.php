<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DO\DTO\DAO\Trait;

use VetmanagerApiGateway\DO\DTO\AbstractDTO;
use VetmanagerApiGateway\DO\DTO\DAO\Interface\AllGetRequestsInterface;

/**
 * Реализация интерфейса {@see AllGetRequestsInterface}. Используется только в DAO - дочерних классах DTO {@see AbstractDTO} этой библиотеки.
 * Не все DTO можно получить по прямому АПИ запросу, только DAO можно
 */
trait AllGetRequestsTrait
{
    use RequestGetAllTrait;
    use RequestGetByIdTrait;
    use RequestGetByQuery;
}
