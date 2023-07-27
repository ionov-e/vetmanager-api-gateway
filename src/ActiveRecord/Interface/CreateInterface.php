<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Interface;

interface CreateInterface
{
    /** Отправка записи на сервер. Вернется созданная модель (с присвоенным ID) */
    public function create(): static;
}