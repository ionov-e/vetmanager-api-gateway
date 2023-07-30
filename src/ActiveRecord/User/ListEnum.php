<?php

namespace VetmanagerApiGateway\ActiveRecord\User;

enum ListEnum: string
{
    case Basic = UserOnly::class;
    case PlusPositionAndRole = UserPlusPositionAndRole::class;
}
