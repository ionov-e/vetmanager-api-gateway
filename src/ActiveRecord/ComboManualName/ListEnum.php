<?php

namespace VetmanagerApiGateway\ActiveRecord\ComboManualName;

enum ListEnum: string
{
    case Basic = ComboManualNameOnly::class;
    case PlusComboManualItems = ComboManualNamePlusComboManualItems::class;
}
