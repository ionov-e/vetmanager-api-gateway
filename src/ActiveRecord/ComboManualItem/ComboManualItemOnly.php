<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\ComboManualItem;

use VetmanagerApiGateway\ActiveRecord\ComboManualName\AbstractComboManualName;
use VetmanagerApiGateway\ActiveRecord\ComboManualName\ComboManualNameOnly;
use VetmanagerApiGateway\DTO\ComboManualItem\ComboManualItemOnlyDto;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayResponseException;
use VetmanagerApiGateway\Facade\ComboManualName;

/**
 * @property-read ComboManualItemOnlyDto $originalDto
 * @property positive-int $id
 * @property positive-int $comboManualId
 * @property string $title Default: ''
 * @property string $value Default: ''
 * @property string $dopParam1 Default: ''
 * @property string $dopParam2 Default: ''
 * @property string $dopParam3 Default: ''
 * @property bool $isActive Default: true
 * @property-read array{
 *       id: string,
 *       combo_manual_id: string,
 *       title: string,
 *       value: string,
 *       dop_param1: string,
 *       dop_param2: string,
 *       dop_param3: string,
 *       is_active: string,
 *       comboManualName: array{
 *               id: string,
 *               title: string,
 *               is_readonly: string,
 *               name: string
 *       }
 *  } $originalDataArray comboManualName при GetAll тоже
 * @property-read ComboManualNameOnly $comboManualName
 */
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
