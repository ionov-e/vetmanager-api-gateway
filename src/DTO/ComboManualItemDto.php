<?php

declare(strict_types=1);

namespace VetmanagerApiGateway\DTO;

use VetmanagerApiGateway\DO\BoolContainer;
use VetmanagerApiGateway\DO\IntContainer;
use VetmanagerApiGateway\DO\StringContainer;
use VetmanagerApiGateway\Exception\VetmanagerApiGatewayException;

/**
 * Обращается в таблицу combo_manual_items
 */
class ComboManualItemDto extends AbstractDTO
{
    /** @var positive-int ID записи цвета в таблице combo_manual_items */
    public int $id;
    /** @var positive-int Тип "подтаблицы". Например, будет всегда одинаковый id для "подтаблицы" с цветами.
     * В БД Default: 0, но ни в одной таблице такого значения не нашел */
    public int $comboManualId;
    /** Default: '' */
    public string $title;
    /** Default: '' */
    public string $value;
    /** Default: '' */
    public string $dopParam1;
    /** Default: '' */
    public string $dopParam2;
    /** Default: '' */
    public string $dopParam3;
    /** Default: 1 */
    public bool $isActive;

    /** @param array{
     *       "id": string,
     *       "combo_manual_id": string,
     *       "title": string,
     *       "value": string,
     *       "dop_param1": string,
     *       "dop_param2": string,
     *       "dop_param3": string,
     *       "is_active": string,
     *       "comboManualName"?: array
     *   } $originalData
     * @throws VetmanagerApiGatewayException
     */
    public function __construct(array $originalData)
    {
        $this->id = IntContainer::fromStringOrNull($originalData['id'])->positiveInt;
        $this->comboManualId = IntContainer::fromStringOrNull($originalData['combo_manual_id'])->positiveInt;
        $this->title = StringContainer::fromStringOrNull($originalData['title'])->string;
        $this->value = StringContainer::fromStringOrNull($originalData['value'])->string;
        $this->dopParam1 = StringContainer::fromStringOrNull($originalData['dop_param1'])->string;
        $this->dopParam2 = StringContainer::fromStringOrNull($originalData['dop_param2'])->string;
        $this->dopParam3 = StringContainer::fromStringOrNull($originalData['dop_param3'])->string;
        $this->isActive = BoolContainer::fromStringOrNull($originalData['is_active'])->bool;
    }
}
