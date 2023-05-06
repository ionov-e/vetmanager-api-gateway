<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Trait;

use VetmanagerApiGateway\ActiveRecord\Interface\AllGetRequestsInterface;

/**
 * Реализация интерфейса {@see AllGetRequestsInterface}. Используется только в DAO - дочерних классах DTO {@see AbstractActiveRecord} этой библиотеки.
 * Не все DTO можно получить по прямому АПИ запросу, только DAO можно
 */
trait AllGetRequestsTrait
{
    use RequestGetAllTrait;
    use RequestGetByIdTrait;
    use RequestGetByQuery;
}
