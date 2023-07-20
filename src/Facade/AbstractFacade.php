<?php

namespace VetmanagerApiGateway\Facade;

use VetmanagerApiGateway\ApiGateway;

abstract class AbstractFacade
{
    public function __construct(protected ApiGateway $apiGateway)
    {
    }
}