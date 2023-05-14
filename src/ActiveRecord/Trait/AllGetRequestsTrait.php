<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Trait;

use VetmanagerApiGateway\ActiveRecord\Interface\AllGetRequestsInterface;

/** Реализация интерфейса {@see AllGetRequestsInterface}. То есть поддержка всех Get-запросов */
trait AllGetRequestsTrait
{
    use RequestGetAllTrait;
    use RequestGetByIdTrait;
    use RequestGetByQuery;
}
