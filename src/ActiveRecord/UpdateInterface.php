<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

interface UpdateInterface
{
    /** Редактировать запись в БД. Отправятся лишь перезаписанные свойства объекта. Остальные останутся без изменения */
    public function update(): static;
}