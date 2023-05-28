<?php

namespace VetmanagerApiGateway\ActiveRecord\Interface;

use VetmanagerApiGateway\ApiGateway;

interface RequestPostInterface
{
    /** Создание новой записи в базе Ветменеджера.
     * Будет создана запись с текущим содержимым объекта с учетом перезаписанных свойств */
    public function createAsNew(): static;

    /** Создание новой записи в базе Ветменеджера: отправка модели по АПИ Post-запросом */
    public static function createAsNewUsingArray(ApiGateway $apiGateway, array $data): static;
}
