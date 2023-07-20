<?php

namespace VetmanagerApiGateway\ActiveRecord;

use VetmanagerApiGateway\DTO\AbstractNewDTO;

abstract class AbstractNewActiveRecord
{
    abstract protected function getPrimaryDto(): AbstractNewDTO;
}