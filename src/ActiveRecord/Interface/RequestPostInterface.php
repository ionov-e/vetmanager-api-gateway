<?php

namespace VetmanagerApiGateway\ActiveRecord\Interface;

use VetmanagerApiGateway\ApiGateway;

interface RequestPostInterface extends BasicDAOInterface
{
    /** Создание новой записи в базе Ветменеджера: отправка модели по АПИ Post-запросом */
    public static function post(ApiGateway $apiGateway, array $data): self;
}
