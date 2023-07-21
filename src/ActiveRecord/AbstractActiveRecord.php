<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\ActiveRecord\Enum\ApiModel;
use VetmanagerApiGateway\ApiGateway;
use VetmanagerApiGateway\DTO\AbstractModelDTO;

abstract class AbstractActiveRecord
{
    protected readonly ApiGateway $apiGateway;

    /** Возвращает в виде DTO в основе текущего объекта Active Record */
    abstract protected function getPrimaryDto(): AbstractModelDTO;

    /** Используется при АПИ-запросах (роуты и имена моделей из тела JSON-ответа на АПИ запрос) */
    abstract public static function getApiModel(): ApiModel;

    public function __set(string $name, mixed $value)
    {
        $this->userMadeDto->$name = $value;
    }
}
