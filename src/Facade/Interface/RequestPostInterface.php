<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\Facade\Interface;

use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;

interface RequestPostInterface
{
    /** Создание чистой Active Record для последующего наполнения и отправки */
    public function getNewEmpty(): AbstractActiveRecord;

    /** Создание новой записи в базе Ветменеджера: отправка модели по АПИ Post-запросом */
    public function createNewUsingArray(array $modelAsArray): AbstractActiveRecord;
}
