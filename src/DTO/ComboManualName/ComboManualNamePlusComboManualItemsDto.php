<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO\ComboManualName;

use VetmanagerApiGateway\DTO\ComboManualItem\ComboManualItemOnlyDto;

class ComboManualNamePlusComboManualItemsDto extends ComboManualNameOnlyDto
{
    /**
     * @param string|null $id
     * @param string|null $title
     * @param string|null $is_readonly
     * @param string|null $name
     * @param ComboManualItemOnlyDto[] $comboManualItems
     */
    public function __construct(
        protected ?string $id,
        protected ?string $title,
        protected ?string $is_readonly,
        protected ?string $name,
        protected array   $comboManualItems
    )
    {
        parent::__construct(
            $id,
            $title,
            $is_readonly,
            $name,
        );
    }

    /** @return ComboManualItemOnlyDto[] */
    public function getComboManualItemsDtos(): array
    {
        return $this->comboManualItems;
    }
}
