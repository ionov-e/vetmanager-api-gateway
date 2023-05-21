<?php

namespace VetmanagerApiGateway\ActiveRecord\Enum;

enum Completeness
{
    case Full;
    case Partial;
    case OnlyBasicDto;
}
