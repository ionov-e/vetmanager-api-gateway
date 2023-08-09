<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\ComboManualItem;

use VetmanagerApiGateway\ActiveRecord\ComboManualName\AbstractComboManualName;
use VetmanagerApiGateway\DTO\ComboManualItem\ComboManualItemOnlyDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Facade\ComboManualName;

final class ComboManualItemOnly extends AbstractComboManualItem
{
    public static function getDtoClass(): string
    {
        return ComboManualItemOnlyDto::class;
    }

    /** @throws VetmanagerApiGatewayException */
    public function getComboManualName(): AbstractComboManualName
    {
        return (new ComboManualName($this->activeRecordFactory))->getById($this->getComboManualId());
    }
}
