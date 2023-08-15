<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\Facade\Interface;

use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;

interface RequestGetAllInterface
{
    /** Получение всех существующих моделей по АПИ Get-запросу
     * @return AbstractActiveRecord[]
     */
    public function getAll(int $maxLimitOfReturnedModels): array;
}
