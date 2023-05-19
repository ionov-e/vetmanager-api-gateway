<?php

namespace VetmanagerApiGateway\ActiveRecord\Enum;

enum Completeness
{
    case Full;
    case Partial1;
    case Partial2;
    case OnlyBasicDto;
}
