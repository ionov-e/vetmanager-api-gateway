<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

interface CreatableInterface
{
    /** Отправка новой записи на сервер. Вернется созданная модель в виде Active Record (с присвоенным ID) */
    public function create(): AbstractActiveRecord;

    /** Редактировать запись в БД. Отправятся лишь перезаписанные свойства объекта. Остальные останутся без изменения */
    public function update(): AbstractActiveRecord;
}