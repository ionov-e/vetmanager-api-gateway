<?php

namespace VetmanagerApiGateway\ActiveRecord\ComboManualItem;

enum ListEnum: string
{
    case Basic = ComboManualItemOnly::class;
    case PlusComboManualName = ComboManualItemPlusComboManualName::class;

}
