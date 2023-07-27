<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\Interface;

interface CreateInterface
{
    /** Отправка новой записи на сервер. Вернется созданная модель в виде Active Record (с присвоенным ID) */
    public function create(): static;
}