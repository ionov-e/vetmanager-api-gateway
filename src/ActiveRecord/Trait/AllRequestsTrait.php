<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Trait;

use VetmanagerApiGateway\ActiveRecord\Interface\AllRequestsInterface;

/** Реализация интерфейса {@see AllRequestsInterface}. То есть поддержка всех возможных запросов */
trait AllRequestsTrait
{
    use AllGetRequestsTrait;
    use RequestPostTrait;
    use RequestPutTrait;
}
