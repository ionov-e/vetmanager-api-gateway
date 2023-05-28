<?php

namespace VetmanagerApiGateway\ActiveRecord\Interface;

use VetmanagerApiGateway\ApiGateway;

interface RequestPutInterface
{
    /** Редактировать запись в БД. Отправятся лишь перезаписанные свойства объекта. Остальные останутся без изменения */
    public function edit(): static;
    /** Редактировать запись в БД
     * @param array $data Стоит отправлять лишь то, что требуется изменить
     */
    public static function editUsingIdAndArray(ApiGateway $apiGateway, int $id, array $data): static;
}
