<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\Facade\Interface;

use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;

interface RequestGetByIdInterface
{
    /** Получение модели (используя ID модели) по АПИ Get-запросу */
    public function getById(int $id): AbstractActiveRecord;
}
