<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\ComboManualItem;

use VetmanagerApiGateway\ActiveRecord\ComboManualName\ComboManualNameOnly;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\ComboManualItem\ComboManualItemPlusComboManualNameDto;

final class ComboManualItemPlusComboManualName extends AbstractComboManualItem
{
    public static function getDtoClass(): string
    {
        return ComboManualItemPlusComboManualNameDto::class;
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, ComboManualItemPlusComboManualNameDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    public function getComboManualName(): ComboManualNameOnly
    {
        return $this->activeRecordFactory->getFromSingleDto($this->modelDTO->getComboManualItemOnlyDto(), ComboManualNameOnly::class);
    }
}
