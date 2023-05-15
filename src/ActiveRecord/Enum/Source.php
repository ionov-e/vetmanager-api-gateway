<?php

namespace VetmanagerApiGateway\ActiveRecord\Enum;

enum Source
{
    case GetById;
    case GetByAllList;
    case GetByQuery;
    case OnlyBasicDto;
}
