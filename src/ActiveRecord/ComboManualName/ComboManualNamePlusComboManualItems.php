<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\ComboManualName;

use VetmanagerApiGateway\ActiveRecord\ComboManualItem\ComboManualItemOnly;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\ComboManualName\ComboManualNamePlusComboManualItemsDto;

final class ComboManualNamePlusComboManualItems extends AbstractComboManualName
{
    public static function getDtoClass(): string
    {
        return ComboManualNamePlusComboManualItemsDto::class;
    }

    public function __construct(ActiveRecordFactory $activeRecordFactory, ComboManualNamePlusComboManualItemsDto $modelDTO)
    {
        parent::__construct($activeRecordFactory, $modelDTO);
        $this->modelDTO = $modelDTO;
    }

    /** @return ComboManualItemOnly[] */
    public function getComboManualItems(): array
    {
        return $this->activeRecordFactory->getFromMultipleDtos($this->modelDTO->getComboManualItemsDtos(), ComboManualItemOnly::class);
    }
}
