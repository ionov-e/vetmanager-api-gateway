<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\Facade\Interface;

use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;

interface RequestPutInterface
{
    /** Редактировать запись в БД
     * @param array $modelAsArray Стоит отправлять лишь то, что требуется изменить
     */
    public function updateUsingIdAndArray(int $id, array $modelAsArray): AbstractActiveRecord;
}
