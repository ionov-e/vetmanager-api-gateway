<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\Facade\Interface;

interface AllGetRequestsInterface extends
    RequestGetAllInterface,
    RequestGetByIdInterface,
    RequestGetByQueryInterface
{
}
