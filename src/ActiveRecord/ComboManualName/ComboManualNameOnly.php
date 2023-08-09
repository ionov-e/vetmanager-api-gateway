<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\ComboManualName;

use VetmanagerApiGateway\DTO\ComboManualName\ComboManualNameOnlyDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade\ComboManualName;

final class ComboManualNameOnly extends AbstractComboManualName
{
    public static function getDtoClass(): string
    {
        return ComboManualNameOnlyDto::class;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getComboManualItems(): array
    {
        return (new ComboManualName($this->activeRecordFactory))->getById($this->getId())->getComboManualItems();
    }
}
