<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\ActiveRecord\ComboManualItem;

use VetmanagerApiGateway\ActiveRecord\AbstractActiveRecord;
use VetmanagerApiGateway\ActiveRecord\ComboManualName\ComboManualNameOnly;
use VetmanagerApiGateway\DTO\ComboManualItem\ComboManualItemOnlyDto;

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
abstract class AbstractComboManualItem extends AbstractActiveRecord
{
    public static function getRouteKey(): string
    {
        return 'comboManualItem';
    }

//    /** @throws VetmanagerApiGatewayException */
//    public function __get(string $name): mixed
//    {
//        return match ($name) {
//            'comboManualName' => ($this->completenessLevel == Completeness::Full)
//                ? ComboManualNameOnly::fromSingleDtoArrayUsingBasicDto($this->activeRecordFactory, $this->originalDataArray['comboManualName'])
//                : ComboManualNameOnly::getById($this->activeRecordFactory, $this->comboManualId),
//            default => $this->originalDto->$name
//        };
//    }
}
