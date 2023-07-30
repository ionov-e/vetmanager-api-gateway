<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\ComboManualName;

use VetmanagerApiGateway\ActiveRecord\ComboManualItem\ComboManualItemOnly;
use VetmanagerApiGateway\ActiveRecordFactory;
use VetmanagerApiGateway\DTO\ComboManualName\ComboManualNameOnlyDto;
use VetmanagerApiGateway\DTO\ComboManualName\ComboManualNamePlusComboManualItemsDto;

/**
 * @property-read ComboManualNameOnlyDto $originalDto
 * @property positive-int $id
 * @property non-empty-string $title
 * @property bool $isReadonly
 * @property non-empty-string $name
 * @property-read array{
 *       id: string,
 *       title: string,
 *       is_readonly: string,
 *       name: string,
 *       comboManualItems: list<array{
 *                                    id: string,
 *                                    combo_manual_id: string,
 *                                    title: string,
 *                                    value: string,
 *                                    dop_param1: string,
 *                                    dop_param2: string,
 *                                    dop_param3: string,
 *                                    is_active: string
 *                                   }
 *                             >
 *   } $originalDataArray 'comboManualItems' массив только при GetById
 * @property-read ComboManualItemOnly[] comboManualItems
 */
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
