<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\DAO\Trait;

use VetmanagerApiGateway\DTO\DAO\Interface\AllGetRequestsInterface;

/**
 * Реализация интерфейса {@see AllGetRequestsInterface}. Используется только в DAO - дочерних классах DTO {@see AbstractDTO} этой библиотеки.
 * Не все DTO можно получить по прямому АПИ запросу, только DAO можно
 */
trait AllGetRequestsTrait
{
    use RequestGetAllTrait, RequestGetByIdTrait, RequestGetByQuery;
}
